<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        return view('notifikasi.index', [
            'notifikasis' => auth()->user()->notifikasi,
        ]);
    }

    public function detail(Request $request, $id_notifikasi)
    {
        $notifikasi = Notifikasi::find($id_notifikasi);

        if ($notifikasi->id_users !== auth()->user()->id_users) {
            return abort(403);
        }

        $notifikasi->is_dibaca = 'dibaca';

        $notifikasi->update();

        return view('notifikasi.detail', [
            'notifikasi' => $notifikasi,
        ]);
    }

    public function fetch(){
        // For the sake of simplicity, assume we have a variable called
        // $notifications with the unread notifications. Each notification
        // have the next properties:
        // icon: An icon for the notification.
        // text: A text for the notification.
        // time: The time since notification was created on the server.
        // At next, we define a hardcoded variable with the explained format,
        // but you can assume this data comes from a database query.

        $notifications = [];

        foreach (auth()->user()->notifikasi as $key => $notifikasi) {
            if($notifikasi->is_dibaca == 'dibaca') continue;
            $notifications[] = [
                'icon' => 'fas fa-fw fa-envelope',
                'text' => 'Pesan Belum Dibaca',
                'time' => '',
            ];
        }

        // Now, we create the notification dropdown main content.

        $dropdownHtml = '';

        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}'></i>";

            $time = "<span class='float-right text-muted text-sm'>
                    {$not['time']}
                    </span>";

            $dropdownHtml .= "<a href='/peserta/notifikasi' class='dropdown-item'>
                                {$icon}{$not['text']}{$time}
                            </a>";

            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }

        // Return the new notification data.

        return [
            'label'       => count($notifications),
            'label_color' => 'danger',
            'icon_color'  => 'dark',
            'dropdown'    => $dropdownHtml,
        ];

    }

}