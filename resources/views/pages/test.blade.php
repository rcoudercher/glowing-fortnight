@extends('layouts.app')

@section('title', 'eee')

@section('content')



  <div>
    <nav class="bg-gray-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img class="h-8 w-8" src="/img/logos/workflow-mark-on-dark.svg" alt="Workflow logo" />
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline">
                <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700">Dashboard</a>
                <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Team</a>
                <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Projects</a>
                <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Calendar</a>
                <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Reports</a>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <button class="p-1 border-2 border-transparent text-gray-400 rounded-full hover:text-white focus:outline-none focus:text-white focus:bg-gray-700" aria-label="Notifications">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
              </button>

              <!-- Profile dropdown -->
              <div class="ml-3 relative">
                <div>
                  <button class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid" id="user-menu" aria-label="User menu" aria-haspopup="true">
                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                  </button>
                </div>
                <!--
                  Profile dropdown panel, show/hide based on dropdown state.

                  Entering: "transition ease-out duration-100"
                    From: "transform opacity-0 scale-95"
                    To: "transform opacity-100 scale-100"
                  Leaving: "transition ease-in duration-75"
                    From: "transform opacity-100 scale-100"
                    To: "transform opacity-0 scale-95"
                -->
                <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                  <div class="py-1 rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white">
              <!-- Menu open: "hidden", Menu closed: "block" -->
              <svg class="block h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <!-- Menu open: "block", Menu closed: "hidden" -->
              <svg class="hidden h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!--
        Mobile menu, toggle classes based on menu state.

        Open: "block", closed: "hidden"
      -->
      <div class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 sm:px-3">
          <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700">Dashboard</a>
          <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Team</a>
          <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Projects</a>
          <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Calendar</a>
          <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Reports</a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
            </div>
            <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">Tom Cook</div>
              <div class="mt-1 text-sm font-medium leading-none text-gray-400">tom@example.com</div>
            </div>
          </div>
          <div class="mt-3 px-2">
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Your Profile</a>
            <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Settings</a>
            <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Sign out</a>
          </div>
        </div>
      </div>
    </nav>

    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold leading-tight text-gray-900">
          Dashboard
        </h1>
      </div>
    </header>
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <div class="px-4 py-6 sm:px-0">
          <div class="border-4 border-dashed border-gray-200 rounded-lg h-96"></div>
        </div>
        <!-- /End replace -->
      </div>
    </main>
  </div>
    
  

  
  {{-- <div>
    <div>
      <div class="_1oQyIsiPHYt6nx7VOmd1sz _3xuFbFM3vrCqdGuKGhhhn0 scrollerItem _3Qkp11fjcAw9I9wtLo8frE _1qftyZQ2bhqP62lbPjoGAh  Post t3_gancar " id="t3_gancar" tabindex="-1">
        <div class="_23h0-EcaBUorIHC-JZyh6J" style="width: 40px; border-left: 4px solid transparent;">
          <div class="_1E9mcoVn4MYnuBQSVDt1gC" id="vote-arrows-t3_gancar">
            <button aria-label="upvote" aria-pressed="false" class="voteButton" data-click-id="upvote" id="upvote-button-t3_gancar">
              <span class="_2q7IQ0BUOWeEZoeAxN555e _3SUsITjKNQ7Tp0Wi2jGxIM qW0l8Af61EP35WIG6vnGk _3edNsMs0PNfyQYofMNVhsG">
                <i class="icon icon-upvote _2Jxk822qXs4DaXwsN7yyHA"></i>
              </span>
            </button>
            <div class="_1rZYMD_4xY3gRcSS3p8ODO" style="color: rgb(26, 26, 27);">5.7k</div>
            <button aria-label="downvote" aria-pressed="false" class="voteButton" data-click-id="downvote">
              <span class="_1iKd82bq_nqObFvSH1iC_Q Q0BxYHtCOJ_rNSPJMU2Y7 _2fe-KdD2OM0ciaiux-G1EL _3yQIOwaIuF6gn8db96Gu7y">
                <i class="icon icon-downvote ZyxIIl4FP5gHGrJDzNpUC"></i>
              </span>
            </button>
          </div>
        </div>
        <div class="_1poyrkZ7g36PawDueRza-J _2uazWzYzM0Qndpz5tFu3EX" data-click-id="background" style="background: rgb(255, 255, 255);">
          <article class="yn9v_hQEhjlRNZI0xspbA">
            <div class="_32pB7ODBwG3OSx1u_17g58" data-click-id="body">
              <div class="BiNC74axuTz66dlnEgicY">
                <div class="cZPZhMe-UCZ8htPodMyJ5">
                  <div class="_3AStxql1mQsrZuUIFP9xSg nU4Je7n-eSXStTBAPMYt8">
                    <span class="_2fCzxBE1dlMh4OFc7B3Dun" style="color: rgb(120, 124, 126);">Posted by</span>
                    <div class="_2mHuuvyV9doV3zwbZPtIPG">
                      <a class="_2tbHP6ZydRpjI44J3syuqC _23wugcdiaj44hdfugIAlnX oQctV4n0yUb0uiHDdGnmE" href="/user/hiddeninsite00/" style="color: rgb(120, 124, 126);">u/hiddeninsite00</a>
                      <div id="UserInfoTooltip--t3_gancar"></div>
                    </div>
                    <a class="_3jOxDPIQ0KaOWpzvSQo-1s" data-click-id="timestamp" href="https://www.reddit.com/r/politics/comments/gancar/pences_barefaced_mayo_clinic_tour_proves_he_still/" id="PostTopMeta--Created--false--t3_gancar" target="_blank" rel="nofollow noopener" style="color: rgb(120, 124, 126);">10 hours ago</a>
                  </div>
                  <div class="_2wFk1qX4e1cxk8Pkw1rAHk"></div>
                  <div class="_2LeW9tc_6Fs1n7Ou8uD-70"></div>
                </div>
              </div>
              <div class="_2FCtq-QzlfuN-SwVMUZMM3 _2wImphGg_1LcEF5MiErvRx t3_gancar">
                <div class="y8HYJ-y_lTUHkQIc1mdCq _2INHSNB8V5eaWp4P0rY_mE">
                  <a data-click-id="body" class="SQnoC3ObvgnGjWt90zD9Z _2INHSNB8V5eaWp4P0rY_mE" href="/r/politics/comments/gancar/pences_barefaced_mayo_clinic_tour_proves_he_still/">
                    <div class="_2SdHzo12ISmrC8H86TgSCp _3wqmjmv3tb_k-PROt7qFZe " theme="[object Object]" style="--posttitletextcolor:#222222;">
                      <h3 class="_eYtD2XCVieq6emjKBH3m">Pence’s Barefaced Mayo Clinic Tour Proves He Still Does Not Take COVID Seriously</h3>
                    </div>
                  </a>
                </div>
                <div class="_1hLrLjnE1G_RBCNcN9MVQf">
                  <img alt="" src="https://www.redditstatic.com/desktop2x/img/renderTimingPixel.png" style="width: 1px; height: 1px;" onload="(__markFirstPostVisible || function(){})();">
                </div>
                <style>
                .t3_gancar ._2FCtq-QzlfuN-SwVMUZMM3 {
                --postTitle-VisitedLinkColor: #9b9b9b;
                --postTitleLink-VisitedLinkColor: #9b9b9b;
                }
                </style>
              </div>
              <div class="_10wC0aXnrUKfdJ4Ssz-o14 ">
                <a href="https://truthout.org/articles/pences-barefaced-mayo-clinic-tour-proves-he-still-does-not-take-covid-seriously/" class="_13svhQIUZqD9PVzFcLwOKT styled-outbound-link" rel="noopener nofollow ugc" target="_blank">truthout.org/articl...<i class="icon icon-outboundLink _2WV2dTLgPlEXLVEmIexAxf"></i></a>
              </div>
            </div>
            <div class="_17nmfaMf1Rq20sVfEmle0O ">
              <div class="ly1p6kYBCM7ZqoRjGeAhw"></div>
              <div class="_2MkcR85HDnYngvlVW2gMMa ">
                <a href="https://truthout.org/articles/pences-barefaced-mayo-clinic-tour-proves-he-still-does-not-take-covid-seriously/" rel="noopener nofollow ugc" target="_blank">
                  <div aria-label="Pence’s Barefaced Mayo Clinic Tour Proves He Still Does Not Take COVID Seriously" class="_2c1ElNxHftd8W_nZtcG9zf _33Pa96SGhFVpZeI6a7Y_Pl " data-click-id="image" role="img" style="background-image: url(&quot;https://b.thumbs.redditmedia.com/egfJeK2GeZk_XSWlR42ltmvCucLdF0AmTq5jVdrVomc.jpg&quot;); border-color: rgb(0, 113, 188);">
                    <div class="m0n699kowSp8Wfa40lqpF">
                      <i class="icon icon-outboundLink _2rOixIHGmpfZB93ihJsw3V"></i>
                    </div>
                    <img alt="Pence’s Barefaced Mayo Clinic Tour Proves He Still Does Not Take COVID Seriously" class="_25ZOvQhQdAqwdxPd5z-KFB hiddenImg">
                  </div>
                </a>
              </div>
            </div>
          </article>
          <div class="XrvmOG7SxKlAJj71Fwi2y">
            <div class="_1E9mcoVn4MYnuBQSVDt1gC _2oM1YqCxIwkvwyeZamWwhW _1Lt8O-wG_BSSv9bpz5gmwV" id="vote-arrows-t3_gancar">
              <button aria-label="upvote" aria-pressed="false" class="voteButton" data-click-id="upvote">
                <span class="_2q7IQ0BUOWeEZoeAxN555e _3SUsITjKNQ7Tp0Wi2jGxIM qW0l8Af61EP35WIG6vnGk _3edNsMs0PNfyQYofMNVhsG">
                  <i class="icon icon-upvote _2Jxk822qXs4DaXwsN7yyHA"></i>
                </span>
              </button>
              <div class="_1rZYMD_4xY3gRcSS3p8ODO _25IkBM0rRUqWX5ZojEMAFQ" style="color: rgb(26, 26, 27);">5.7k</div>
              <button aria-label="downvote" aria-pressed="false" class="voteButton" data-click-id="downvote">
                <span class="_1iKd82bq_nqObFvSH1iC_Q Q0BxYHtCOJ_rNSPJMU2Y7 _2fe-KdD2OM0ciaiux-G1EL _3yQIOwaIuF6gn8db96Gu7y">
                  <i class="icon icon-downvote ZyxIIl4FP5gHGrJDzNpUC"></i>
                </span>
              </button>
            </div>
            <div class="_3-miAEojrCvx_4FQ8x3P-s">
              <a rel="nofollow" data-click-id="comments" data-test-id="comments-page-link-num-comments" class="_1UoeAeSRhOKSNdY_h3iS1O _1Hw7tY9pMr-T1F4P1C-xNU _2qww3J5KKzsD7e5DO0BvvU" href="/r/politics/comments/gancar/pences_barefaced_mayo_clinic_tour_proves_he_still/">
                <i class="icon icon-comment _3ch9jJ0painNf41PmU4F9i _3DVrpDrMM9NLT6TlsTUMxC" role="presentation"></i>
                <span class="FHCV02u6Cp2zYL0fhQPsO">241 comments</span>
              </a>
              <div class="_JRBNstMcGxbZUxrrIKXe _3yh2bniLq7bYr4BaiXowdO _1pShbCnOaF7EGWTq6IvZux _3sUJGnemgtNczijwoT8PGg" id="t3_gancar-share-menu">
                <button data-click-id="share" class="kU8ebCMnbXfjCWfqn0WPb">
                  <i class="icon icon-share xwmljjCrovDE5C9MasZja _1GQDWqbF-wkYWbrpmOvjqJ"></i>
                  <span class="_6_44iTtZoeY6_XChKt5b0">share</span>
                </button>
              </div>
              <button class="_10K5i7NW6qcm-UoCtpB3aK YszYBnnIoNY8pZ6UwCivd _3yh2bniLq7bYr4BaiXowdO _2sAFaB0tx4Hd5KxVkdUcAx _3sUJGnemgtNczijwoT8PGg">
                <span class="pthKOcceozMuXLYrLlbL1">
                  <i class="icon icon-save _3n1jtdyipCtmS0HkOM1Tfd _2V4nGS1AmzWhA62lzdCu4r"></i>
                </span>
                <span class="_2-cXnP74241WI7fpcpfPmg">save</span>
              </button>
              <div class="OccjSdFd6HkHhShRg6DOl"></div>
              <div>
                <button aria-expanded="false" aria-haspopup="true" aria-label="more options" id="t3_gancar-overflow-menu" class="_2pFdCpgBihIaYh9DSMWBIu _1EbinKu2t3KjaT2gR156Qp uMPgOFYlCc5uvpa2Lbteu">
                  <i class="icon icon-menu _2L8b_l8zFzAkWuMyZJ1_vg _38GxRFSqSC-Z2VLi5Xzkjy"></i>
                </button>
              </div>
              <div class="_21pmAV9gWG6F_UKVe7YIE0"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  

 --}}



















{{-- <div class="container mx-auto">
  <button onclick="window.location.href='{{ route('home') }}'">go home</button>
</div>
 --}}



{{-- <div id="notif-container" class="absolute top-0 right-0 mr-5 mt-24 w-1/4">
  @for ($i=0; $i < 5; $i++)
    <div class="py-3 pl-6 pr-3 rounded-lg bg-gray-900 shadow-lg mb-4">
      <div class="flex items-center justify-between flex-wrap">
        <div class="w-full flex-1 flex items-center sm:w-0">
          <p class="text-gray-200">Get the HTML</p>
        </div>
        <div class="flex-shrink-0">
            <div class="rounded-md shadow-sm">
              <a href="/pricing" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded text-gray-900 bg-white hover:text-gray-600 focus:outline-none focus:shadow-outline transition ease-in-out duration-150">
                X
              </a>
            </div>
          </div>
      </div>
    </div>
  @endfor
  @for ($i=0; $i < 5; $i++)
    <div class="py-3 pl-6 pr-3 rounded-lg bg-red-300 shadow-lg mb-4">
      <div class="flex items-center justify-between flex-wrap">
        <div class="w-full flex-1 flex items-center sm:w-0">
          <p class="text-red-900">Communauté bien créée.</p>
        </div>
        <div class="flex-shrink-0">
            <div class="rounded-md shadow-sm">
              <a href="/pricing" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded text-gray-900 bg-white hover:text-gray-600 focus:outline-none focus:shadow-outline transition ease-in-out duration-150">
                X
              </a>
            </div>
          </div>
      </div>
    </div>
  @endfor
</div> --}}






@endsection
