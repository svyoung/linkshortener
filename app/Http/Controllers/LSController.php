<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
use Storage;

class LSController extends Controller
{
    public $lc = array(
            'a','b','c','d','e','f','g','h','i','j','k','i','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'
            ),
        $uc = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
            ),
        $num = array(
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9
            );
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layout');
    }

    public function getLink(Request $request) {
        $data = $request->all();
        $host = $_SERVER['HTTP_HOST'];
        if(!empty($data)) {
            if(!$this->doesUrlExist($data[0])['exists']) {
                $newKey = $this->getRandomCode();   
                $isUnique =  $this->isCodeUnique($newKey);
                while(!$isUnique) {
                    $newKey = $this->getRandomCode();
                    $isUnique =  $this->isCodeUnique($newKey);
                }
                if($isUnique && $this->isUrlValid($data[0])) {
                    $shorturl = $host.'/'.$newKey;
                    try {
                        $query = DB::table('links')->insert(
                            [
                                'longurl' => $data[0],
                                'shorturlkey' => $newKey
                            ]
                        );
                        return response()->json($shorturl);
                    } catch(\Exception $e) {
                        return response()->json(false);
                    }
                }
            } else {
                $shorturl = $host.'/'.$this->doesUrlExist($data[0])['result'][0]['shorturlkey'];
                return response()->json($shorturl);
            }
        }

        return response()->json(false);
    }

    public function isUrlValid($url) {
        $ext_list = Storage::disk('local')->get('domain_ext_list.json');
        $ext_list = json_decode($ext_list);
        $parsed = parse_url($url);

        if (empty($parsed['scheme'])) {
            return false;
        } else {
            foreach($ext_list as $ext) {
                if (strpos($url, $ext->ext) != false) {
                    return true;
                }
            }
        }
        return false;
    }

    public function doesUrlExist($url) {
        $query = DB::table('links')
                        ->where([
                            ['longurl', '=', $url]
                        ])
                        ->get();

        return [ 
                'exists' => !!(json_decode(json_encode($query), true)),
                'result' => json_decode(json_encode($query), true)
                ];
    }

    public function isCodeUnique($code) {
        $query = DB::table('links')
            ->where([
                ['shorturlkey', '=', $code]
            ])
            ->get();

        return empty(json_decode(json_encode($query), true));
    }

    public function getRandomCode() {
        return $code = $this->lc[rand(0,25)]
                . $this->num[rand(0,9)]
                . $this->lc[rand(0,25)]
                . $this->num[rand(0,9)]
                . $this->uc[rand(0,25)]
                . $this->uc[rand(0,25)]
                . $this->num[rand(0,9)]
                . $this->num[rand(0,9)];
    }

    public function redirectLink($code) {
        // var_dump($code); exit();
        if(empty($code)) {
            return redirect('/');
        } else {
            try {
            $query = DB::table('links')
                ->where([
                    ['shorturlkey', '=', $code]
                ])
                ->get();
                $query = json_decode(json_encode($query, true));

                return redirect()->away($query[0]->longurl);
                // var_dump($query[0]->longurl);
            } catch(\Exception $e) {
                return response()->json(false);
            }
        }
        
    }
}
