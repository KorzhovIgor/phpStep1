<?php

use App\Controllers\CommentsController;
use App\Traits\Render;
use PHPUnit\Framework\TestCase;

class CommentsControllerTest extends TestCase
{
    /**
     * @deprecated
     *
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testIndex(): void
    {
        $commentsControllerMock = $this->getMockBuilder(CommentsController::class)
            ->onlyMethods(['render'])
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->getMock();

        $commentsControllerMock->expects($this->once())
            ->method('render')
            ->with($this->isType('string'), $this->isType('array'))
            ->willReturnCallback(function () {
                echo 'Everything is ok';
            });

        $commentsControllerMock->index('page=1');
        $this->expectOutputString('Everything is ok');
    }
}
