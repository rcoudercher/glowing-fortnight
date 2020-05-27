<div class="card">
  <h4 class="title h4">k/{{ $community->display_name }}</h4>
  <ul>
    <li class="mb-2"><a class="link" href="{{ route('communities.admin.dashboard', ['community' => $community]) }}">Accueil admin</a></li>
    <li class="mb-2"><a class="link" href="{{ route('communities.show', ['community' => $community]) }}">Page publique</a></li>
    <li class="mb-2"><a class="link" href="{{ route('communities.settings.edit', ['community' => $community]) }}">Configuration</a></li>
    <li class="mb-2">
      <a class="link" href="{{ route('communities.moderation.index', ['community' => $community]) }}">Modération</a>
      <span class="px-1 bg-red-300 rounded">{{ $community->getModerationCount() }}</span>
    </li>
  </ul>
</div>