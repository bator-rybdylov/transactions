<?php

namespace Core;

class Controller {
    public $view;

    function __construct()
    {
        $this->view = new View();
    }

    /**
     * Redirect to $path.
     * Messages is saved to session.
     * @param $path
     * @param array $messages
     */
    public function redirect($path, $messages = [])
    {
        if (count($messages) > 0) {
            foreach ($messages as $key => $message) {
                $_SESSION[$key] = $message;
            }
        }

        header("Location: " . $path);
        exit();
    }
}