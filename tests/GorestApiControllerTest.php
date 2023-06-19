<?php

use App\Controllers\GorestApiController;
use App\Services\GorestApi;
use PHPUnit\Framework\TestCase;

class GorestApiControllerTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetComments()
    {
        $gorestApiStub = $this->createStub(GorestApi::class);
        $gorestApiStub->expects($this->any())
            ->method('getComments')
            ->willReturn($this->commentFromGorestApi());
        $gorestApiController = new GorestApiController($gorestApiStub);

        $this->expectOutputString($this->commentFromGorestApi());
        $gorestApiController->getComments('per_page=1&page=10');
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetComment()
    {
        $gorestApiMock = $this->createMock(GorestApi::class);
        $gorestApiMock->expects($this->any())
            ->method('getComment')
            ->willReturn($this->commentFromGorestApi());
        $gorestApiController = new GorestApiController($gorestApiMock);

        $this->expectOutputString($this->commentFromGorestApi());
        $gorestApiController->getComment(1);
    }

    /**
     * @return void
     */
    public function testStoreComment()
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "http://start.test/api/gorestApi/comments/store",
            CURLOPT_HTTPHEADER => ['Content-Type' => 'application/json'],
            CURLOPT_RETURNTRANSFER => 1
        ];
        $auth = AUTH_GOREST_API;
        curl_setopt_array($curl, $options);
        $res = curl_exec($curl);
        $this->assertEquals('Auth problem', $res);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "Authorization: $auth"
        ]);
        $res = curl_exec($curl);
        curl_close($curl);
        $this->assertNotEquals('Auth problem', $res);
    }

    /**
     * @return void
     */
    public function testPutComment()
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "http://start.test/api/gorestApi/comments/put/39454",
            CURLOPT_HTTPHEADER => ['Content-Type' => 'application/json'],
            CURLOPT_RETURNTRANSFER => 1
        ];
        $auth = AUTH_GOREST_API;
        curl_setopt_array($curl, $options);
        $res = curl_exec($curl);
        $this->assertEquals('Auth problem', $res);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "Authorization: $auth"
        ]);
        $res = curl_exec($curl);
        curl_close($curl);
        $this->assertNotEquals('Auth problem', $res);
    }

    /**
     * @return void
     */
    public function testPatchComment()
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "http://start.test/api/gorestApi/comments/patch/39454",
            CURLOPT_HTTPHEADER => ['Content-Type' => 'application/json'],
            CURLOPT_RETURNTRANSFER => 1
        ];
        $auth = AUTH_GOREST_API;
        curl_setopt_array($curl, $options);
        $res = curl_exec($curl);
        $this->assertEquals('Auth problem', $res);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "Authorization: $auth"
        ]);
        $res = curl_exec($curl);
        curl_close($curl);
        $this->assertNotEquals('Auth problem', $res);
    }

    /**
     * @return void
     */
    public function testDeleteComment()
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "http://start.test/api/gorestApi/comment/delete/39454",
            CURLOPT_HTTPHEADER => ['Content-Type' => 'application/json'],
            CURLOPT_RETURNTRANSFER => 1
        ];
        $auth = AUTH_GOREST_API;
        curl_setopt_array($curl, $options);
        $res = curl_exec($curl);
        $this->assertEquals('Auth problem', $res);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "Authorization: $auth"
        ]);
        $res = curl_exec($curl);
        curl_close($curl);
        $this->assertNotEquals('Auth problem', $res);
    }


    /**
     * @return string
     */
    private function commentFromGorestApi(): string
    {
        return json_encode([
            'meta' => 'null',
            'data' => [
                'id' => 41221,
                'post_id' => 45892,
                'name' => 'Gov. Aadrika Prajapat',
                'email' => 'prajapat_aadrika_gov@botsford.test',
                'body' => 'Ab voluptatem sit. Vero dolor beatae.'
            ]
        ]);
    }

}
