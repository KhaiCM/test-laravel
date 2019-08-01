<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Slide;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateSlideRequest;
use App\Repo\SlideRepositoryInterface;
use Cache;

class SlideController extends Controller
{
    protected $slideRepository;

    /**     
     * Create a new controller instance.
     * @return void
     **/
    public function __construct(SlideRepositoryInterface $slideRepository)
    {
        $this->slideRepository = $slideRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listSlide = Cache::remember('slides', 600, function(){
            return \DB::table('slides')->get();
        });
        // $listSlide = Slide::all();
        $compact = [
            'listSlide' => $listSlide,
        ];

        return view('slide.index', $compact);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slide = Slide::find($id);
        $slide->value = json_decode($slide->value);
        // dd($slide->value);
        return view('slide.edit' . $id, ['slide' => $slide]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSlideRequest $request, $id)
    {
        $slide = $this->slideRepository->updateSlide($request, $id);

        return redirect()->route('slide.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
