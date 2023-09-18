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
            'url_address' => 'required',
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

        $url->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan');
    }

    private function generateShortCode($customCode)
{
    $code = 'https://s.' . uniqid(); // Menghasilkan kode unik

    // Check if the generated code already exists in the database
    $exists = Url::where('url_short', $code)->exists();

    // If the code exists, generate a new one until it's unique
    while ($exists) {
        $code = 'https://s.' . uniqid(); // Generate a new code
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
            return redirect($urlRecord->url_address);
        } else {
            // Handle the case where the short URL does not exist
            return view('not_found'); // You can create a "not_found" blade view
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
        $qrCode = QrCode::size(200)
            ->format('png')
            ->errorCorrection('M')
            ->generate($url);
    
        // Specify the file path where the QR code image should be saved
        $filePath = public_path('qrcodes/' . $imageName . '.png');
    
        // Save the QR code image to the specified file path
        file_put_contents($filePath, $qrCode);
    
        // Return the path to the generated QR code image
        return $filePath;
    }
    

    public function destroy($id_url)
    {
        $url = Url::find($id_url);
        if ($url) {
            if ($url->qrcode_image) {
                Storage::disk('public')->delete($url->qrcode_image);
            }
            $url->delete();
        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

}
