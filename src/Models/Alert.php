<?php

namespace Models;

class Alert
{
    // Ajouter une alerte à la session
    public static function add($mode, $msg)
    {
        if (!isset($_SESSION['alerts'])) {
            $_SESSION['alerts'] = [];
        }
        $_SESSION['alerts'][] = ['mode' => $mode, 'msg' => $msg];
    }

    // Récupérer toutes les alertes
    public static function get()
    {
        if (!isset($_SESSION['alerts'])) {
            return [];
        }
        $alerts = $_SESSION['alerts'];
        unset($_SESSION['alerts']); // Nettoie après récupération
        return $alerts;
    }

    // Vérifier s'il y a des alertes
    public static function hasAlerts()
    {
        return !empty($_SESSION['alerts']);
    }

    public static function displayHtml()
    {
        $html = '';
        $alerts = \Models\Alert::get();
        if (!empty($alerts)) {
            $html .= '<div class="alerts">';
            foreach ($alerts as $alert):
                $html .= '<div class="alert alert-' . $alert['mode'] . ' shadow">';
                $html .= $alert['msg'];
                $html .= '</div>';
            endforeach;
            $html .= '</div>';
        }
        return $html;
    }
}
