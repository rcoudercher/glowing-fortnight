<div class="card">
  <h4 class="title h4">k/{{ $community->display_name }}</h4>
  <ul>
    <li class="mb-2"><a class="link" href="{{ route('communities.admin.dashboard', ['community' => $community]) }}">accueil admin</a></li>
    <li class="mb-2"><a class="link" href="{{ route('communities.show', ['community' => $community]) }}">page publique</a></li>
    <li class="mb-2"><a class="link" href="{{ route('communities.settings.edit', ['community' => $community]) }}">configuration</a></li>
    <li class="mb-2"><a class="link" href="{{ route('communities.moderation.index', ['community' => $community]) }}">modération</a></li>
    
  </ul>
</div>