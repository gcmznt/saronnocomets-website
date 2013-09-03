<?php
    class Facebook
    {       
        /**
         * @var The page id to edit
         */
        private $page_id = '';   
     
        /**
         * @var the page access token given to the application above
         */
        private $page_access_token = ''; 
     
        /**
         * @var The back-end service for page's wall
         */
        private $post_url = '';
     
        /**
         * Constructor, sets the url's
         */
        public function Facebook()
        {
            $this->post_url = 'https://graph.facebook.com/'.$this->page_id.'/feed';
        }
     
        /**
         * Manages the POST message to post an update on a page wall
         * 
         * @param array $data
         * @return string the back-end response
         * @private
         */
        public function message($data)
        {   
            // need token
            $data['access_token'] = $this->page_access_token;
     
            // init
            $ch = curl_init();
     
            curl_setopt($ch, CURLOPT_URL, $this->post_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     
            // execute and close
            $return = curl_exec($ch);
            curl_close($ch);
     
            // end
            echo $return;        
        }
    }
    


    function post_on_facebook($post_text = '', $url = '') {
        $facebook = new Facebook();
         
        $facebook->message(
            array(
                'message'     => $post_text, 
                'link'        => $url, 
                // 'picture'     => 'http://thepicturetoinclude.jpg',
                // 'name'        => 'Name of the picture, shown just above it', 
                // 'description' => 'Full description explaining whether the header or the picture',
            )
        );
    }

