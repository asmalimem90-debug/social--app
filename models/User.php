<?php
declare(strict_types=1);

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(string $nom, string $email, string $hashedPassword, ?string $image): int|false
    {
        $stmt = $this->db->prepare(
            'INSERT INTO utilisateurs (nom, email, motDePasse, image) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$nom, $email, $hashedPassword, $image]);
        $id = (int)$this->db->lastInsertId();
        return $id > 0 ? $id : false;
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM utilisateurs WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM utilisateurs WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    
    public function update(int $id, array $data): bool
    {
        $allowed = ['nom', 'email', 'motDePasse', 'image'];
        $sets    = [];
        $values  = [];

        foreach ($data as $col => $val) {
            if (in_array($col, $allowed, true)) {
                $sets[]   = "`$col` = ?";
                $values[] = $val;
            }
        }

        if (empty($sets)) {
            return false;
        }

        $values[] = $id;
        $stmt = $this->db->prepare(
            'UPDATE utilisateurs SET ' . implode(', ', $sets) . ' WHERE id = ?'
        );
        $stmt->execute($values);
        return $stmt->rowCount() >= 0; 
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM utilisateurs WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

   
    public function search(string $query, int $excludeId): array
    {
        $like = '%' . $query . '%';
        $stmt = $this->db->prepare(
            'SELECT id, nom, email, image, dateCreation
             FROM utilisateurs
             WHERE id != ? AND (nom LIKE ? OR email LIKE ?)
             ORDER BY nom
             LIMIT 30'
        );
        $stmt->execute([$excludeId, $like, $like]);
        return $stmt->fetchAll();
    }
}
