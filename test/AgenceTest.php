<?php

use PHPUnit\Framework\TestCase;
use Models\Agence;
use Config\Database;

class AgenceTest extends TestCase
{
    private Agence $agence;
    private PDO $db;

    protected function setUp(): void
    {
        $database = new Database();
        $this->db = $database->getConnection();

        // Nettoyer la table avant chaque test
        $this->db->exec("DELETE FROM agences");

        $this->agence = new Agence();
    }

    public function testCreate()
    {
        $result = $this->agence->create("Test Agence");
        $this->assertTrue($result);

        $stmt = $this->db->prepare("SELECT * FROM agences WHERE nom = :nom");
        $stmt->execute([':nom' => 'Test Agence']);
        $agence = $stmt->fetch();

        $this->assertNotEmpty($agence);
        $this->assertEquals("Test Agence", $agence['nom']);
    }

    public function testUpdate()
    {
        $this->agence->create("Old Name");
        $stmt = $this->db->query("SELECT id_agence FROM agences WHERE nom = 'Old Name'");
        $id = $stmt->fetch()['id_agence'];

        $result = $this->agence->update($id, "New Name");
        $this->assertTrue($result);

        $updated = $this->agence->getById($id);
        $this->assertEquals("New Name", $updated['nom']);
    }

    public function testDelete()
    {
        $this->agence->create("To Delete");
        $stmt = $this->db->query("SELECT id_agence FROM agences WHERE nom = 'To Delete'");
        $id = $stmt->fetch()['id_agence'];

        $result = $this->agence->delete($id);
        $this->assertTrue($result);

        $deleted = $this->agence->getById($id);
        $this->assertNull($deleted);
    }
}
