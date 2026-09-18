<?php
declare(strict_types=1);

class FriendRequest
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    } 

    public function send(int $demandeurId, int $recepteurId): int|false
    {
        if ($demandeurId === $recepteurId) {
            return false;
        }
        try {
            $stmt = $this->db->prepare(
                'INSERT INTO demande_amis (demandeur_id, recepteur_id, statut)
                 VALUES (?, ?, \'EN_ATTENTE\')'
            );
            $stmt->execute([$demandeurId, $recepteurId]);
            return (int)$this->db->lastInsertId();
        } catch (PDOException) {
            return false; 
        }
    }

    public function cancel(int $id, int $demandeurId): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM demande_amis WHERE id = ? AND demandeur_id = ? AND statut = 'EN_ATTENTE'"
        );
        $stmt->execute([$id, $demandeurId]);
        return $stmt->rowCount() > 0;
    }

    
    public function accept(int $id, int $recepteurId): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE demande_amis SET statut = 'ACCEPTEE' WHERE id = ? AND recepteur_id = ? AND statut = 'EN_ATTENTE'"
        );
        $stmt->execute([$id, $recepteurId]);
        return $stmt->rowCount() > 0;
    }


    public function reject(int $id, int $recepteurId): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE demande_amis SET statut = 'REJETEE' WHERE id = ? AND recepteur_id = ? AND statut = 'EN_ATTENTE'"
        );
        $stmt->execute([$id, $recepteurId]);
        return $stmt->rowCount() > 0;
    }

    public function getSent(int $demandeurId): array
    {
        $stmt = $this->db->prepare(
            'SELECT da.*, u.nom AS nom_recepteur, u.image AS image_recepteur
             FROM demande_amis da
             JOIN utilisateurs u ON u.id = da.recepteur_id
             WHERE da.demandeur_id = ?
             ORDER BY da.dateCreation DESC'
        );
        $stmt->execute([$demandeurId]);
        return $stmt->fetchAll();
    }

    public function getReceived(int $recepteurId): array
    {
        $stmt = $this->db->prepare(
            "SELECT da.*, u.nom AS nom_demandeur, u.image AS image_demandeur
             FROM demande_amis da
             JOIN utilisateurs u ON u.id = da.demandeur_id
             WHERE da.recepteur_id = ? AND da.statut = 'EN_ATTENTE'
             ORDER BY da.dateCreation DESC"
        );
        $stmt->execute([$recepteurId]);
        return $stmt->fetchAll();
    }

    public function countPendingReceived(int $recepteurId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM demande_amis WHERE recepteur_id = ? AND statut = 'EN_ATTENTE'"
        );
        $stmt->execute([$recepteurId]);
        return (int)$stmt->fetchColumn();
    }


    public function getRelation(int $userId, int $otherId): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM demande_amis
             WHERE (demandeur_id = ? AND recepteur_id = ?)
                OR (demandeur_id = ? AND recepteur_id = ?)
             ORDER BY dateCreation DESC
             LIMIT 1'
        );
        $stmt->execute([$userId, $otherId, $otherId, $userId]);
        return $stmt->fetch();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM demande_amis WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
