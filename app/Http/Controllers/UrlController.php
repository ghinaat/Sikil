<?php

namespace App\Http\Controllers;
use App\Models\Url;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function index()
    {
        $url = Url::All();

        return view('url.index', [
            'url' => $url,
            'user'   => User::where('is_deleted', '0')->get()
        ]);
    }

    public function store(Request $request)
    {
        //Menyimpan Data Keluarga Baru
        $request->validate([
            'id_users' => 'required',
            'url_address' => 'required|url',
            'jenis' => 'required',
            'url_short' => 'required',

        ]);

        $url = new Url();
        $url->id_users = $request->id_users;
        $url->url_address = $request->url_address;
        $url->jenis = $request->jenis;
        $customCode = $request->input('url_short');
        $url->url_short = $this->generateShortCode($customCode);
        $qrcode = $this->generateQRCode($request->input('url_address'));
        $url->qrcode_image = $qrcode;

        // dd($url);
        $url->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan');
    }

    private function generateShortCode($customCode)
    {
        $existingUrl = Url::where('url_short', $customCode)->first();

        if ($existingUrl) {
            return redirect()->back()->with('error_message', 'URL pendek sudah ada dalam basis data.');
        }


        $code = $customCode;

        // Check if the generated code already exists in the database
        $exists = Url::where('url_short', $code)->exists();

        // If the code exists, generate a new one until it's unique
        while ($exists) {
            $code =  $customCode; // Generate a new code
            $exists = Url::where('url_short', $code)->exists();
        }

        return $code;
    }



        public function redirect($shortUrl)
    {
        // Look up the short URL in the database
        $urlRecord = Url::where('url_short', $shortUrl)->first();

        // Check if the short URL exists in the database
        if ($urlRecord) {
            // Redirect to the original URL
            return redirect()->away($urlRecord->url_address);
        } else {
            // Handle the case where the short URL does not exist
            return redirect()->back()->with('error_message', 'Tidak Ditemukan Url.');
        }
    }

    private function generateQRCode($url, $imageName = null)
    {
        if (is_null($imageName)) {
            $imageName = uniqid('qrcode_');
        }

        // Check if the URL exists in the database, assuming you have an 'Url' model
        $urlExists = Url::where('url_address', $url)->exists();

        // Generate the QR code
        $qrCode = QrCode::size(200)->format('png')->errorCorrection('M')->generate($url);

        // Specify the file path where the QR code image should be saved
        $storagePath = 'public/qrcodes/' . $imageName . '.png';

        // Store the QR code image in the storage directory
        Storage::put($storagePath, $qrCode);

        // Return the URL to the stored QR code image
        // dd(str_replace('public/', '', $storagePath));
         return $imageName . '.png';
    }

    public function update(Request $request, $id_url)
    {
        $request->validate([
            'id_users' => 'required',
            'url_address' => 'required|url',
            'jenis' => 'required',
            'url_short' => 'required',
        ]);
        $url = Url::find($id_url);
        $url->id_users = $request->id_users;
        $url->url_address = $request->url_address;
        $url->jenis = $request->jenis;
        if (!empty($url->qrcode_image)) {
            Storage::delete('qrcodes/' . $url->qrcode_image);
            $url->qrcode_image = null;
        }
        $customCode = $request->input('url_short');
        $url->url_short = $this->generateShortCode($customCode);
        $qrcode = $this->generateQRCode($request->input('url_address'));
        $url->qrcode_image = $qrcode;
        $url->save();
            return redirect()->back()->with('success_message', 'Data telah tersimpan');
        }



    public function destroy($id_url)
    {
        $url = Url::find($id_url);
        if ($url) {
            if ($url->qrcode_image) {
                Storage::disk('public')->delete('qrcodes/'.$url->qrcode_image);
            }
            $url->delete();
        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

}