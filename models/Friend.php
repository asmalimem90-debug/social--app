<?php
declare(strict_types=1);

class Friend
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    private function ordered(int $a, int $b): array
    {
        return $a < $b ? [$a, $b] : [$b, $a];
    }

   

    public function add(int $userId, int $otherId): bool
    {
        [$u1, $u2] = $this->ordered($userId, $otherId);

        try {
            $stmt = $this->db->prepare(
                'INSERT INTO amis (utilisateur1_id, utilisateur2_id) VALUES (?, ?)'
            );
            $stmt->execute([$u1, $u2]);
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    public function remove(int $userId, int $otherId): bool
    {
        [$u1, $u2] = $this->ordered($userId, $otherId);

        $stmt = $this->db->prepare(
            'DELETE FROM amis WHERE utilisateur1_id = ? AND utilisateur2_id = ?'
        );
        $stmt->execute([$u1, $u2]);

        return $stmt->rowCount() > 0;
    }


    public function areFriends(int $userId, int $otherId): bool
    {
        [$u1, $u2] = $this->ordered($userId, $otherId);

        $stmt = $this->db->prepare(
            'SELECT 1 FROM amis WHERE utilisateur1_id = ? AND utilisateur2_id = ? LIMIT 1'
        );
        $stmt->execute([$u1, $u2]);

        return (bool)$stmt->fetchColumn();
    }

    public function getFriends(int $userId): array
    {
        $stmt = $this->db->prepare(
            'SELECT u.id, u.nom, u.email, u.image, a.dateCreation AS amis_depuis
             FROM amis a
             JOIN utilisateurs u 
             ON u.id = IF(a.utilisateur1_id = ?, a.utilisateur2_id, a.utilisateur1_id)
             WHERE a.utilisateur1_id = ? OR a.utilisateur2_id = ?
             ORDER BY u.nom'
        );

        $stmt->execute([$userId, $userId, $userId]);

        return $stmt->fetchAll();
    }

    public function getCount(int $userId): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM amis
             WHERE utilisateur1_id = ? OR utilisateur2_id = ?'
        );

        $stmt->execute([$userId, $userId]);

        return (int)$stmt->fetchColumn();
    }

    public function getCommonFriends(int $userId, int $otherId): array
    {
        $stmt = $this->db->prepare(
            'SELECT u.id, u.nom, u.image
             FROM utilisateurs u
             WHERE u.id IN (
                 SELECT CASE 
                     WHEN utilisateur1_id = ? THEN utilisateur2_id 
                     ELSE utilisateur1_id 
                 END
                 FROM amis
                 WHERE utilisateur1_id = ? OR utilisateur2_id = ?
             )
             AND u.id IN (
                 SELECT CASE 
                     WHEN utilisateur1_id = ? THEN utilisateur2_id 
                     ELSE utilisateur1_id 
                 END
                 FROM amis
                 WHERE utilisateur1_id = ? OR utilisateur2_id = ?
             )'
        );

        $stmt->execute([
            $userId, $userId, $userId,
            $otherId, $otherId, $otherId
        ]);

        return $stmt->fetchAll();
    }

 
    public function getSuggestions(int $userId, int $limit = 10): array
{
    $limit = (int)$limit;

    $sql = "
        SELECT u.id, u.nom, u.image,
               COUNT(DISTINCT cf.id) AS amis_communs
        FROM utilisateurs u
        JOIN amis cf ON (
            (cf.utilisateur1_id = u.id OR cf.utilisateur2_id = u.id)
            AND (cf.utilisateur1_id = ? OR cf.utilisateur2_id = ?)
            AND cf.utilisateur1_id != u.id 
            AND cf.utilisateur2_id != u.id
        )
        WHERE u.id != ?
        AND u.id NOT IN (
            SELECT CASE 
                WHEN utilisateur1_id = ? THEN utilisateur2_id 
                ELSE utilisateur1_id 
            END
            FROM amis 
            WHERE utilisateur1_id = ? OR utilisateur2_id = ?
        )
        AND u.id NOT IN (
            SELECT recepteur_id FROM demande_amis WHERE demandeur_id = ?
            UNION
            SELECT demandeur_id FROM demande_amis WHERE recepteur_id = ?
        )
        GROUP BY u.id
        ORDER BY amis_communs DESC
        LIMIT $limit
    ";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        $userId, $userId,  
        $userId,            
        $userId,            
        $userId, $userId,   
        $userId,            
        $userId             
    ]);

    return $stmt->fetchAll();
}
}
