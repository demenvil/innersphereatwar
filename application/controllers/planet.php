<?php

class Planet extends MY_Controller {
    
    /**
     * Default constructor
     */
    function __construct()
    {
        parent::__construct();
        
        // Make sure the user is signed in
        if ( !$this->ion_auth->logged_in() )
        {
            redirect('auth/login', 'refresh');
        }
    }
    
    /**
     * Create a new planet
     */
    function create($game_id=0)
    {
        $page = $this->page;
        
        $this->load->library('form_validation');
        $this->load->model('gamemodel');
        $this->load->model('planetmodel');
        
        // Validate form input
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[200]');
        if ($this->form_validation->run() == FALSE)
        { 
            // Show the form
            $page['game'] = $this->gamemodel->get_by_id($game_id);
            $page['content'] = 'planet_form';
            $this->load->view('template', $page);
        }
        else
        {
            // Create the new planet
            $game = $this->gamemodel->get_by_id($game_id);
            
            $planet = new stdClass();
            $planet->name = $this->input->post('name');
            $planet->game_id = $game_id;
            $planet->type = $this->input->post('type');
            $planet->x = $this->input->post('x');
            $planet->y = $this->input->post('y');
            $this->planetmodel->create($planet);
            
            $this->session->set_flashdata('notice', 'Planet created.');
            redirect('planet/view/'.$this->db->insert_id(), 'refresh');
        }
    }
    
    /**
     * Edit a planet
     */
    function edit($planet_id=0)
    {
        $page = $this->page;
        
        $this->load->library('form_validation');
        $this->load->model('gamemodel');
        $this->load->model('planetmodel');
        $planet = $this->planetmodel->get_by_id($planet_id);
        $game = $this->gamemodel->get_by_id($planet->game_id);
        
        // Validate form input
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[200]');
        if ($this->form_validation->run() == FALSE)
        { 
            // Show the form
            $page['planet'] = $planet;
            $page['content'] = 'planet_form_edit';
            $this->load->view('template', $page);
        }
        else
        {
            // Edit the planet
            $planet->name = $this->input->post('name');
            $planet->type = $this->input->post('type');
            $planet->x = $this->input->post('x');
            $planet->y = $this->input->post('y');
            $this->planetmodel->update($planet_id, $planet);
            
            $this->session->set_flashdata('notice', 'Planet Updated.');
            redirect('planet/view/'.$planet_id, 'refresh');
        }
        
    }
    
    /**
     * Delete a planet
     */
    function delete($planet_id=0)
    {
        $page = $this->page;
        
        $this->load->model('planetmodel');
        $this->load->model('gamemodel');
        $planet = $this->planetmodel->get_by_id($planet_id);
        $game = $this->gamemodel->get_by_id($planet->game_id);
        $this->planetmodel->delete($planet_id);
        $this->session->set_flashdata('notice', 'Planet deleted.');
        redirect('planet/view_game/'.$game->game_id, 'refresh');
    }
    
    /**
     * View a planet
     */
    function view($planet_id=0)
    {
        $page = $this->page;
        
        $this->load->model('planetmodel');
        $this->load->model('commandmodel');
        $page['planet'] = $this->planetmodel->get_detail_by_id($planet_id);
        $page['planets'] = $this->planetmodel->get_by_game($page['planet']->game_id);
        $page['commands'] = $this->commandmodel->get_by_planet($planet_id);
        $page['content'] = 'planet_view';
        $this->load->view('template', $page);
    }
    
    /**
     * View this planets aero map 
     */
    function view_aero($planet_id=0)
    {
        $page = $this->page;
        
        $this->load->model('planetmodel');
        $this->load->model('tokenmodel');
        $this->load->model('factionmodel');
        $this->load->model('gamemodel');
        $this->load->model('playermodel');
        $page['planet'] = $this->planetmodel->get_by_id($planet_id);
        $page['tokens'] = $this->tokenmodel->get_by_planet($planet_id, 'Aero');
        $page['faction'] = $this->factionmodel->get_by_game_user($page['planet']->game_id, $this->page['user']->id);
        $page['game'] = $this->gamemodel->get_by_id($page['planet']->game_id);
        $page['player'] = $this->playermodel->get_by_user_game($page['user']->id, $page['game']->game_id);
        $page['content'] = 'planet_view_aero';
        $this->load->view('template', $page);
    }
    
    /**
     * View this planets ground map
     */
    function view_ground($planet_id=0)
    {
        $page = $this->page;
        
        $this->load->model('planetmodel');
        $this->load->model('tokenmodel');
        $this->load->model('factionmodel');
        $this->load->model('gamemodel');
        $this->load->model('playermodel');
        $page['planet'] = $this->planetmodel->get_by_id($planet_id);
        $page['tokens'] = $this->tokenmodel->get_by_planet($planet_id, 'Ground');
        $page['faction'] = $this->factionmodel->get_by_game_user($page['planet']->game_id, $this->page['user']->id);
        $page['game'] = $this->gamemodel->get_by_id($page['planet']->game_id);
        $page['player'] = $this->playermodel->get_by_user_game($page['user']->id, $page['game']->game_id);
        $page['content'] = 'planet_view_ground';
        $this->load->view('template', $page);
    }
    
    /**
     * View this planets planetary combat map
     */
    function view_pcm($planet_id=0)
    {
        $page = $this->page;
        
        $this->load->model('planetmodel');
        $this->load->model('tokenmodel');
        $this->load->model('factionmodel');
        $this->load->model('gamemodel');
        $this->load->model('playermodel');
        $page['planet'] = $this->planetmodel->get_by_id($planet_id);
        $page['tokens'] = $this->tokenmodel->get_by_planet($planet_id, 'Ground');
        $page['faction'] = $this->factionmodel->get_by_game_user($page['planet']->game_id, $this->page['user']->id);
        $page['game'] = $this->gamemodel->get_by_id($page['planet']->game_id);
        $page['player'] = $this->playermodel->get_by_user_game($page['user']->id, $page['game']->game_id);
        $page['content'] = 'planet_view_pcm';
        $this->load->view('template', $page);
    }
    
    /**
     * View all planets in a game
     */
    function view_game($game_id=0)
    {
        $page = $this->page;
        
        $this->load->model('planetmodel');
        $page['planets'] = $this->planetmodel->get_by_game($game_id);
        $this->load->model('gamemodel');
        $page['game'] = $this->gamemodel->get_by_id($game_id);
        $page['content'] = 'planet_view_list';
        $this->load->view('template', $page);
    }
    
    /**
     * View information on a hex
     */
    function view_hex($planet_id=0, $hex_row=0, $hex_column=0)
    {
        $page = $this->page;
        $this->load->model('planetmodel');
        $planet = $this->planetmodel->get_by_id($planet_id);
        
        // Get formations at this hex
        $this->load->model('formationmodel');
        $formations = $this->formationmodel->get_by_planet_hex($planet_id, $hex_row, $hex_column);
        
        $page['planet'] = $planet;
        $page['formations'] = $formations;
        $page['row'] = $hex_row;
        $page['col'] = $hex_column;
        $page['content'] = 'planet_view_hex';
        $this->load->view('templatexml', $page);
    }
    
    /**
     * Update the planetary ACS turn
     */
    function update_turn($planet_id=0, $adjustment=0)
    {
        $page = $this->page;
        $this->load->model('planetmodel');
        $planet = $this->planetmodel->get_by_id($planet_id);
        $planet->turn += $adjustment;
        if ($planet->turn < 1)
            $planet->turn = 8;
        else if ($planet->turn > 8)
            $planet->turn = 1;
        $this->planetmodel->update($planet_id, $planet);        
    }
    
    /**
     * Update the planetary ACS phase
     */
    function update_phase($planet_id=0, $adjustment=0)
    {
        $page = $this->page;
        $this->load->model('planetmodel');
        $planet = $this->planetmodel->get_by_id($planet_id);
        $planet->phase += $adjustment;
        if ($planet->phase < 1)
        {
            $planet->phase = 8;
        }
        else if ($planet->phase > 8)
        {
            $planet->phase = 1;
        }
        $this->planetmodel->update($planet_id, $planet);        
    }
    
    /**
     * Update this planet
     */
    function update($planet_id=0, $location=0)
    {
        $page = $this->page;
        $this->load->model('tokenmodel');
        $page['tokens'] = $this->tokenmodel->get_by_planet($planet_id, $location);
        $this->load->view('planet_update', $page);
    }
    
    /**
     * Clear the salvage pool
     */
    function clear_salvage($planet_id=0)
    {
        $page = $this->page;
        $this->load->model('planetmodel');
        $planet = $this->planetmodel->get_by_id($planet_id);
        $planet->salvage_pool = 0;
        $this->planetmodel->update($planet_id, $planet);
        $this->session->set_flashdata('notice', 'Salvage Cleared.');
        redirect('planet/view/'.$planet_id, 'refresh');
    }
    
    /**
     * Fast Combat Resolution
     */
    function fast_combat($planet_id=0)
    {
        $page = $this->page;
        $this->load->helper('combats');
        fast_resolve($planet_id);
        $this->session->set_flashdata('notice', 'Combat Rolled.  Please resolve Combat Unit deaths and Morale.');
        redirect('planet/view/'.$planet_id, 'refresh');
    }
}

