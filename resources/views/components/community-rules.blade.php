<div class="card">
  <h4 class="title h4 mb-2">Règles de k/{{ $community->display_name }}</h4>
  <div id="rulesBox">
    @foreach ($community->communityRules->sortBy('order') as $rule)
      <div class="mb-2 border-b border-gray-300 wrapper">
        <div class="pb-2 cursor-pointer flex">
          <div class="flex-grow">
            {{ $loop->iteration }}. {{ $rule->title }}
          </div>
          @if (!is_null($rule->description ))
            <div class="">
              <i class="fas fa-chevron-down"></i>
            </div>
          @endif
        </div>
        @if (!is_null($rule->description ))
          <div class="pb-2 hidden">{{ $rule->description }}</div>
        @else
          <div class="hidden"></div>
        @endif        
      </div>
    @endforeach
  </div>
</div>





<script type="text/javascript">


  function toggleDescription(el) {
    // el = clicked element
    if (el === null) {
      return console.log("Invalid function parameter: 'el' was null.");
    }
    var description = el.closest(".wrapper").lastElementChild;    
    description.classList.toggle("hidden");
    console.log("request successful");
  }

  var rules = document.getElementById("rulesBox").children;
  
  for (var i = 0; i < rules.length; i++) {
    rules.item(i).addEventListener("click", function(e) {
      var target = e.target || e.srcElement;
      toggleDescription(target);
    });
    
  }
  
</script>