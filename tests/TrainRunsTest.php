<?php

namespace TrainsTest;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use Trains;

class TrainRunsTest extends TestCase { 

    public function setUp(): void {
        $this->TrainRun = new Trains\TrainRuns();
    }

    public function tearDown(): void {
        unset($TrainRun);

    }

    public function testUploadRuns() {
        $file_content = "TRAIN_LINE, ROUTE_NAME, RUN_NUMBER, OPERATOR_ID\r\n
                El, Brown Line,E102, SJones\r\n
                Metra, UPN,M405, AJohnson\r\n
                Amtrak, Hiawatha,A006, LBeck\r\n";
        file_put_contents('traintest2.csv', $file_content);
        $output = $this->TrainRun->uploadRuns('traintest2.csv');
        $this->assertTrue($output);

    }
    public function provideRuns(): array {
        return [[
            [['El', 'Brown Line', '420', 'CJones'],
            ['Metra', 'UPN', '306', 'FKwerp'],
            ['Amtrak','Lake Shore Limited', '48', 'SGrabowski'],
            ['Metra', 'Rock Island', '614', 'JNDAOU'],
            ['Amtrak', 'Coast Starlight', '14', 'PTatulis'],
            ['El', 'Green Line', '625', 'SSash']]]
        ];

    }

    /**
     * @dataProvider provideRuns
     */
    public function testSortByTrainLine(array $runs) {
        $sorted = array(
            ['Amtrak', 'Coast Starlight', '14', 'PTatulis'],
            ['Amtrak','Lake Shore Limited', '48', 'SGrabowski'],
            ['El', 'Brown Line', '420', 'CJones'],
            ['El', 'Green Line', '625', 'SSash'],
            ['Metra', 'Rock Island', '614', 'JNDAOU'],
            ['Metra', 'UPN', '306', 'FKwerp']
        );
        $output = $this->TrainRun->sortRuns($runs, 0);
        $this->assertEquals($sorted, $output);
    }

    /**
     * @dataProvider provideRuns
     */
    public function testSortByRoute(array $runs) {
        $sorted = array(
            ['El', 'Brown Line', '420', 'CJones'],
            ['Amtrak', 'Coast Starlight', '14', 'PTatulis'],
            ['El', 'Green Line', '625', 'SSash'],
            ['Amtrak','Lake Shore Limited', '48', 'SGrabowski'],
            ['Metra', 'Rock Island', '614', 'JNDAOU'],
            ['Metra', 'UPN', '306', 'FKwerp']
        );
        $output = $this->TrainRun->sortRuns($runs, 1);
        $this->assertEquals($sorted, $output);
    }

    /**
     * @dataProvider provideRuns
     */
    public function testSortByRunNumber(array $runs) {
        $sorted = array(
            ['Amtrak', 'Coast Starlight', '14', 'PTatulis'],
            ['Amtrak','Lake Shore Limited', '48', 'SGrabowski'],
            ['Metra', 'UPN', '306', 'FKwerp'],
            ['El', 'Brown Line', '420', 'CJones'],
            ['Metra', 'Rock Island', '614', 'JNDAOU'],
            ['El', 'Green Line', '625', 'SSash'],
        );
        $output = $this->TrainRun->sortRuns($runs, 2);
        $this->assertEquals($sorted, $output);
    }

    /**
     * @dataProvider provideRuns
     */
    public function testSortByOperatorID(array $runs) {
        $sorted = array(
            ['El', 'Brown Line', '420', 'CJones'],
            ['Metra', 'UPN', '306', 'FKwerp'],
            ['Metra', 'Rock Island', '614', 'JNDAOU'],
            ['Amtrak', 'Coast Starlight', '14', 'PTatulis'],
            ['Amtrak','Lake Shore Limited', '48', 'SGrabowski'],
            ['El', 'Green Line', '625', 'SSash']
        );
        $output = $this->TrainRun->sortRuns($runs, 3);
        $this->assertEquals($sorted, $output);
    }

    public function provideDuplicateRuns(): array {
        return [[
            [['El', 'Brown Line', '420', 'CJones'],
            ['Metra', 'UPN', '306', 'FKwerp'],
            ['Metra', 'UPN', '306', 'FKwerp'],
            ['Metra', 'UPN', '306', 'FKwerp'],
            ['Metra', 'UPN', '306', 'FKwerp'],
            ['Amtrak','Lake Shore Limited', '48', 'SGrabowski'],
            ['Metra', 'Rock Island', '614', 'JNDAOU'],
            ['Metra', 'UPN', '306', 'FKwerp'],
            ['Amtrak', 'Coast Starlight', '14', 'PTatulis'],
            ['El', 'Green Line', '625', 'SSash']]]
        ];

    }

    /**
     * @dataProvider provideDuplicateRuns
     */
    public function testSortByOperatorIDNoDupes(array $runs) {
        // Let's make sure we're eliminating duplicate data.
        $sorted = array(
            ['El', 'Brown Line', '420', 'CJones'],
            ['Metra', 'UPN', '306', 'FKwerp'],
            ['Metra', 'Rock Island', '614', 'JNDAOU'],
            ['Amtrak', 'Coast Starlight', '14', 'PTatulis'],
            ['Amtrak','Lake Shore Limited', '48', 'SGrabowski'],
            ['El', 'Green Line', '625', 'SSash']
        );
        $output = $this->TrainRun->sortRuns($runs, 3);
        $this->assertEquals($sorted, $output);
    }

}