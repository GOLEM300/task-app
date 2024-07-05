<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testTaskIndex() : void
    {
        $task_1 = Task::factory()->create(['date_to_finish' => '2024-07-10', 'status' => 'done']);
        $task_2 = Task::factory()->create(['date_to_finish' => '2024-07-15', 'status' => 'wait']);
        $task_3 = Task::factory()->create(['date_to_finish' => '2024-07-20', 'status' => 'in_working']);

        $response = $this->json('GET', '/api/v1/tasks', [
            'date_to_finish' => '2024-07-15',
            'status' => 'wait',
        ]);

        $response->assertStatus(200)->assertJsonCount(1)->assertJsonFragment(['id' => $task_2->id]);
    }

    /**
     * @return void
     */
    public function testTaskCreate() : void
    {
        $data = [
            'title' => 'task_test',
            'description' => 'description text',
            'date_create' => '2024-07-31',
            'date_to_finish' => '2024-07-31',
            'status' => 'wait',
        ];

        $response = $this->json('POST', '/api/v1/tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @return void
     */
    public function testTaskUpdate() : void
    {
        $task = Task::factory()->create();

        $form_data = [
            'title' => 'task_test',
            'description' => 'description text',
            'date_create' => '2024-07-31',
            'date_to_finish' => '2024-07-31',
            'status' => 'wait',
        ];

        $response = $this->json('PUT', "/api/v1/tasks/{$task->id}", $form_data);

        $response->assertStatus(200)->assertJson($form_data);
    }

    /**
     * @return void
     */
    public function testTaskShow() : void
    {
        $task = Task::factory()->create();

        $response = $this->json('GET', "/api/v1/tasks/{$task->id}");

        $response->assertStatus(200)->assertJson(['id' => $task->id]);
    }

    /**
     * @return void
     */
    public function testTaskDelete(): void
    {
        $task = Task::factory()->create();

        $response = $this->json('DELETE', "/api/v1/tasks/{$task->id}");

        $response->assertStatus(200)->assertJson(['message' => 'Task deleted']);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
