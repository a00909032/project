<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Application {

    /**
     * Index Page for this controller.
     */
    public function index() {
        $this->data['pagebody'] = 'home';

        $seriesTab = $this->series->all();
        $playerTab = $this->players->all();

        $series = array();
        foreach ($seriesTab as $row) {
            $item = array(
                'Series' => $row->Series,
                'Description' => $row->Description,
                'Frequency' => $row->Frequency,
                'Value' => $row->Value,
                'Acquired' => 0
            );
            $series[] = $item;
        }

        $players = array();
        foreach ($playerTab as $player) {
            $pitem = array(
                'Player' => $player->Player,
                'Peanuts' => $player->Peanuts,
                'Equity' => (count($this->collections->some('Player', $player->Player)) + $player->Peanuts)
            );
            $players[] = $pitem;
        }

        $summary_player['player'] = $players;
        $summary['collection'] = $series;
        $this->data['playerLists'] = $this->parser->parse('_playerLists', $summary_player, true);
        $this->data['botPieces'] = $this->parser->parse('_botPieces', $summary, true);

        $this->render();
    }

}
