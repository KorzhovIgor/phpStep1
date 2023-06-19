<?php

use App\Models\Comment;
use Database\DBConnection;
use PHPUnit\Framework\TestCase;

class CommentsModelTest extends TestCase
{
    /**
     * @return void
     */
    public function testStore(): void
    {
        $commentModel = new Comment;
        $db = DBConnection::getInstance();
        $db->beginTransaction();
        $commentModel->store('TheBestTitle', 'The best content');
        $preparedRequest = $db->prepare('SELECT title FROM comments WHERE title = ?');
        $preparedRequest->execute(['TheBestTitle']);
        $this->assertEquals('TheBestTitle', $preparedRequest->fetch()['title']);
        $db->rollBack();
    }

    /**
     * @return void
     */
    public function testGetByID(): void
    {
        $commentModel = new Comment;
        $db = DBConnection::getInstance();
        $db->beginTransaction();
        $commentModel->store('TheBestTitle', 'The best content');
        $preparedRequest = $db->prepare('SELECT id FROM comments WHERE title = ? AND content = ?');
        $preparedRequest->execute(['TheBestTitle', 'The best content']);
        $id = $preparedRequest->fetch()['id'];
        $this->assertEquals($id, json_decode($commentModel->getByID($id))->id);
        $db->rollBack();
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $commentModel = new Comment;
        $db = DBConnection::getInstance();
        $db->beginTransaction();
        $commentModel->store('TheBestTitle', 'The best content');
        $preparedRequest = $db->prepare('SELECT id FROM comments WHERE title = ? AND content = ?');
        $preparedRequest->execute(['TheBestTitle', 'The best content']);
        $id = $preparedRequest->fetch()['id'];
        $preparedRequest = $db->prepare('DELETE FROM comments WHERE id = ?');
        $preparedRequest->execute([$id]);
        $preparedRequest = $db->prepare('SELECT id FROM comments WHERE title = ? AND content = ?');
        $preparedRequest->execute(['TheBestTitle', 'The best content']);
        $id = $preparedRequest->fetch()['id'];
        $this->assertEquals(null, $id);
        $db->rollBack();
    }
}
