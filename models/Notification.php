<?php
declare(strict_types=1);

class Notification
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // ─── Write operations ────────────────────────────────────

    public function create(int $utilisateurId, string $type, ?int $referenceId = null): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO notifications (utilisateur_id, type, reference_id)
             VALUES (?, ?, ?)'
        );
        $stmt->execute([$utilisateurId, $type, $referenceId]);
        return $stmt->rowCount() > 0;
    }

    public function markAsRead(int $id, int $utilisateurId): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE notifications SET is_read = TRUE WHERE id = ? AND utilisateur_id = ?'
        );
        $stmt->execute([$id, $utilisateurId]);
        return $stmt->rowCount() > 0;
    }

    public function markAllAsRead(int $utilisateurId): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE notifications SET is_read = TRUE WHERE utilisateur_id = ?'
        );
        $stmt->execute([$utilisateurId]);
        return true;
    }

    // ─── Read operations ─────────────────────────────────────

    /**
     * Get all notifications for a user, newest first.
     * Joins with demande_amis and utilisateurs to get actor name.
     */
    public function getByUser(int $utilisateurId): array
    {
        $stmt = $this->db->prepare(
            'SELECT n.*,
                    da.demandeur_id, da.recepteur_id,
                    ua.nom  AS nom_acteur,
                    ua.image AS image_acteur
             FROM notifications n
             LEFT JOIN demande_amis da ON da.id = n.reference_id
             LEFT JOIN utilisateurs ua ON ua.id = CASE
                 WHEN n.type = \'demandeAmitié\'   THEN da.demandeur_id
                 WHEN n.type = \'demandeAcceptée\' THEN da.demandeur_id
                 WHEN n.type = \'demandeRefusée\'  THEN da.recepteur_id
                 ELSE NULL
             END
             WHERE n.utilisateur_id = ?
             ORDER BY n.dateCreation DESC
             LIMIT 50'
        );
        $stmt->execute([$utilisateurId]);
        return $stmt->fetchAll();
    }

    public function getUnreadCount(int $utilisateurId): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM notifications WHERE utilisateur_id = ? AND is_read = FALSE'
        );
        $stmt->execute([$utilisateurId]);
        return (int)$stmt->fetchColumn();
    }
}
