<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Type;

use App\Poem;

use Auth;

class TypesController extends Controller
{
    public function __construct()
    {
       return $this->middleware(['mustFollow', 'FirstTime']);        
    }    

    // RENDERING THE INDIVIDUAL POEM TYPES VIEW

    public function show($type)
    {

    	$t=Type::where('type',$type)->first();

        $poems=Poem::where('type_id', $t->id)->orderBy('created_at','desc')->take(10)->get();

    	$user=Auth::user();

    	$id_array=[];

    	foreach($user->types as $type)
    	{
    		array_push($id_array, $type->id);
    	}

    	$other_types=Type::inRandomOrder()->whereNotIn('id', $id_array)->take(5)->get();

        $poemcount=Poem::where('type_id', $t->id)->count();

    	return view('type.show')->with('typez',$t)
                                ->with('poems', $poems)
                                ->with('other_types', $other_types)
    							->with('poem_count', $poemcount);	

    }

    // LOADING MORE POEMS INTO THE PAGE FROM AN AJAX REQUEST

    public function fetchMore(Request $request, $get_num)
    {
        $type=Type::where('type', $request->type)->first();

        $poems=Poem::where('type_id', $type->id)->orderBy('created_at','desc')->paginate($get_num);

        return view('poems.poem')->with('poems', $poems);
    }
}
