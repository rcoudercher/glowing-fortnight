<?php

namespace App\Http\Controllers\Front;

use App\CommunityRule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Community;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CommunityRuleController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Community $community)
    {
      if (!Auth::user()->isAdmin($community)) {
        return redirect(route('front.communities.show', ['community' => $community]))
        ->with('error', 'Cette page est réservée aux administrateurs de la communauté.');
      }
      
      $communityRule = new CommunityRule(); // passes an empty model to the view
      return view('community-rules.create', compact('community', 'communityRule'));
    }

    public function store(Community $community, Request $request)
    {
      if (!Auth::user()->isAdmin($community)) {
        return redirect(route('front.communities.show', ['community' => $community]))
        ->with('error', 'Cette action est réservée aux administrateurs de la communauté.');
      }
      
      $count = $community->communityRules->count();
          
      $data = [
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'order' => $count + 1,
        'creator_id' => Auth::user()->id,
        'community_id' => $community->id,
      ];
      
      $rules = [
        'title' => ['required', 'string', 'max:50'],
        'description' => ['nullable', 'string', 'max:300'],
        'order' => ['required', 'integer', 'min:1', 'max:20'],
        'creator_id' => ['required', 'integer', 'exists:App\User,id'],
        'community_id' => ['required', 'integer', 'exists:App\Community,id'],
      ];
      
      $validator = Validator::make($data, $rules)->validate();
      
      // find unique hash
      $hashes = CommunityRule::all()->pluck('hash');
      $hash = Str::random(6);
      while ($hashes->contains($hash)) {
        $hash = Str::random(6);
      }
      // end find unique hash
      
      $validator['hash'] = $hash; 
          
      $communityRule = CommunityRule::create($validator);
      
      return redirect(route('front.communities.admin.dashboard', ['community' => $community]))
      ->with('message', 'Nouvelle règle bien créée');
    }

    public function show(CommunityRule $communityRule)
    {
        //
    }

    public function edit(Community $community, CommunityRule $communityRule)
    {
      // if logged in user isn't one of the community admins, redirect to community show
      if (!Auth::user()->isAdmin($community)) {
        return redirect(route('front.communities.show', ['community' => $community]))
        ->with('error', 'Cette action est réservée aux administrateurs de la communauté.');
      }
      
      // Custom Keys & Scoping / route : Laravel will make sure that the given community rule belongs to the given community
      
      return view('community-rules.edit', compact('community', 'communityRule'));
    }

    public function update(Request $request, Community $community, CommunityRule $communityRule)
    {      
      $data = [
        'title' => $request->input('title'),
        'description' => $request->input('description'),
      ];
      
      $rules = [
        'title' => ['required', 'string', 'max:50'],
        'description' => ['nullable', 'string', 'max:300'],
      ];
      
      $validator = Validator::make($data, $rules)->validate();
      
      $communityRule->update($validator); // update model
      
      return redirect(route('front.communities.admin.dashboard', ['community' => $community]))
      ->with('message', 'Modifications enregistrées.');
    }

    public function destroy(Community $community, CommunityRule $communityRule)
    {
      // reorder rules before deleting the rule
      foreach ($community->communityRules->where('order', '>', $communityRule->order) as $rule) {
        $rule->order -= 1;
        $rule->save();
      }
      
      $communityRule->delete();
      return redirect(route('front.communities.admin.dashboard', ['community' => $community]))
      ->with('message', 'Règle bien suprimée.');
    }
    
    public function up(Community $community, CommunityRule $communityRule)
    {
      $previousRule = $community->communityRules->where('order', $communityRule->order - 1)->first();
      
      if (is_null($previousRule)) {
        return back()->with('error', 'Impossible de changer l\'ordre de cette règle.');
      }
      
      // previous rule is down ranked
      $previousRule->order += 1;
      $previousRule->save();
      
      // clicked rule is up ranked
      $communityRule->order -= 1;
      $communityRule->save();
      
      return redirect(route('front.communities.admin.dashboard', ['community' => $community]))
      ->with('message', 'Ordre des règles bien changé.');
    }
    
    public function down(Community $community, CommunityRule $communityRule)
    {
      $nextRule = $community->communityRules->where('order', $communityRule->order + 1)->first();
      
      if (is_null($nextRule)) {
        return back()->with('error', 'Impossible de changer l\'ordre de cette règle.');
      }
      
      // next rule is up ranked
      $nextRule->order -= 1;
      $nextRule->save();
      
      // clicked rule is down ranked
      $communityRule->order += 1;
      $communityRule->save();
      
      return redirect(route('front.communities.admin.dashboard', ['community' => $community]))
      ->with('message', 'Ordre des règles bien changé.');
    }
}
