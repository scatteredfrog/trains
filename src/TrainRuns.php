<?php

namespace Trains;

class TrainRuns
{

    public function uploadRuns($file_path) {
        $_SESSION['runs'] = [];
        $open = fopen($file_path, "r");
        while(($run = fgetcsv($open)) !== false) {
            // We'll check for a header row and ignore it when buliding the array.
            if ($run[0] != 'TRAIN_LINE') {
                $_SESSION['runs'][] = $run;
            }
        }
        if (!empty($_SESSION['runs'])) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Sorts the array of runs based on column:
     * 0 = train line
     * 1 = route name
     * 2 = run number
     * 3 = operator ID
     * @param array $runs
     * @param int $key
     * @return array
     */
    public function sortRuns(array $runs, int $column): array {
        $key_values = array_column($runs, $column);
        $found_duplicate = false;
        array_multisort($key_values, SORT_ASC, SORT_NATURAL|SORT_FLAG_CASE, $runs);

        // All entries displayed must be unique. Here we filter out dupes.
        foreach ($runs as $run) {
            $imploded_run[] = implode('~', $run);
        }
        $implode_count = is_countable($imploded_run) ? count($imploded_run) : 0;

        for ($x = 0; $x < ($implode_count-1) ; $x++) {
            if ($imploded_run[$x] == $imploded_run[$x+1]) {
                $found_duplicate = true;
                unset($imploded_run[$x]);
            }
        }
        if ($found_duplicate) {
            $imploded_run = $this->_reindexArray($imploded_run);
            $runs = [];
            foreach ($imploded_run as $imp) {
                $runs[] = explode('~', $imp);
            }
            unset($imploded_run);
        }
        
        return $runs;
    }

    /**
     * When unsetting an element from a numerically-indexed array, there could be 
     * some unwanted results. This function returns such an array with no gaps in the
     * indices.
     * @param array $old_array - the array with potentially out-of-sequence indices
     * @return array $new_array - the array with repaired indicies
     */
    private function _reindexArray(array $old_array): array {
        $new_array = [];
        foreach ($old_array as $array) {
            $new_array[] = $array;
        }
        unset($old_array);
        return $new_array;
    }
}