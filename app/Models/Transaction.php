<?php
declare(strict_types=1);

namespace App\Models;

use App\Model;
use PDO;

class Transaction extends Model
{
    public function create(\DateTime $date, int $check, string $description, float $amount): int
    {
        $stmt = $this->db->prepare('
            insert into transactions (`date`, `check`, `description`, `amount`)
            values (?, ?, ?, ?)'
        );

        $stmt->execute([$date->format('Y-m-d'), $check, $description, $amount]);

        return (int)$this->db->lastInsertId();
    }

    public function readAll(): array
    {
        $stmt = $this->db->prepare('select `date`, `check`, `description`, `amount` from transactions');

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
