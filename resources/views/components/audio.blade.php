 <section class="w-full bg-cardBg rounded-2xl p-8 shadow-lg relative overflow-hidden border border-gray-700/50">

     <!-- Background Glow -->
     <div class="absolute inset-0 bg-gradient-to-r from-purple-600/10 via-transparent to-cyan-400/10 blur-3xl"></div>

     <div class="relative space-y-6">

         <!-- Controls Row -->
         <div class="flex items-center gap-4">
             <!-- Play / Pause -->
             <button id="playPauseBtn"
                 class="control-btn w-12 h-12 flex items-center justify-center rounded-full
                           bg-gradient-to-r from-primary to-secondary
                           shadow-lg hover:shadow-xl">
                 <!-- Play -->
                 <svg id="playIcon" class="w-5 h-5 fill-white ml-0.5" viewBox="0 0 24 24">
                     <path d="M8 5v14l11-7z" />
                 </svg>

                 <!-- Pause -->
                 <svg id="pauseIcon" class="w-5 h-5 fill-white hidden" viewBox="0 0 24 24">
                     <path d="M6 5h4v14H6zm8 0h4v14h-4z" />
                 </svg>
             </button>

             <!-- Time Display -->
             <span id="currentTime" class="text-sm text-mutedText font-mono w-12">0:00</span>

             <!-- Progress Slider -->
             <input type="range" id="progressSlider" class="progress-slider flex-1" min="0" max="100"
                 value="0" title="Seek">

             <!-- Duration Display -->
             <span id="duration" class="text-sm text-mutedText font-mono w-12">0:00</span>
         </div>

         <!-- Volume Control Row -->
         <div class="flex items-center gap-3 pl-16">
             <button id="volumeBtn" class="control-btn text-mutedText hover:text-white transition">
                 <svg id="volumeIcon" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                     <path
                         d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.26 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z" />
                 </svg>
             </button>
             <input type="range" id="volumeSlider" class="volume-slider" min="0" max="100" value="100"
                 title="Volume">
         </div>

         <!-- Audio Element -->
         <audio id="audioPlayer" src="{{ $link }}" crossorigin="anonymous"></audio>

     </div>
 </section>

 @push('scripts')
     <script>
         // Elements
         const audio = document.getElementById('audioPlayer');
         const playBtn = document.getElementById('playPauseBtn');
         const playIcon = document.getElementById('playIcon');
         const pauseIcon = document.getElementById('pauseIcon');
         const progressSlider = document.getElementById('progressSlider');
         const currentTimeEl = document.getElementById('currentTime');
         const durationEl = document.getElementById('duration');
         const volumeSlider = document.getElementById('volumeSlider');
         const volumeBtn = document.getElementById('volumeBtn');

         // Quantity controls
         const increaseBtn = document.getElementById('increaseBtn');
         const decreaseBtn = document.getElementById('decreaseBtn');
         const quantityDisplay = document.getElementById('quantityDisplay');
         let quantity = 1;

         /* ---------- Play / Pause ---------- */
         playBtn.addEventListener('click', () => {
             if (audio.paused) {
                 audio.play().catch(() => console.log('Play blocked'));
             } else {
                 audio.pause();
             }
         });

         /* ---------- Audio State Updates ---------- */
         audio.addEventListener('play', () => {
             playIcon.classList.add('hidden');
             pauseIcon.classList.remove('hidden');
         });

         audio.addEventListener('pause', () => {
             playIcon.classList.remove('hidden');
             pauseIcon.classList.add('hidden');
         });

         /* ---------- Load Metadata ---------- */
         audio.addEventListener('loadedmetadata', () => {
             progressSlider.max = audio.duration;
             durationEl.textContent = formatTime(audio.duration);
         });

         let isSliderActive = false;

         /* ---------- Update Progress ---------- */
         audio.addEventListener('timeupdate', () => {
             if (!audio.duration || isSliderActive) return;
             progressSlider.value = audio.currentTime;
             currentTimeEl.textContent = formatTime(audio.currentTime);
         });

         /* ---------- Seek via Slider ---------- */
         progressSlider.addEventListener('mousedown', () => {
             isSliderActive = true;
         });

         progressSlider.addEventListener('input', () => {
             if (isSliderActive) {
                 const newTime = parseFloat(progressSlider.value);
                 audio.currentTime = newTime;
                 currentTimeEl.textContent = formatTime(newTime);
             }
         });

         progressSlider.addEventListener('mouseup', () => {
             isSliderActive = false;
         });

         progressSlider.addEventListener('mouseleave', () => {
             isSliderActive = false;
         });

         /* ---------- Volume Control ---------- */
         volumeSlider.addEventListener('input', () => {
             audio.volume = volumeSlider.value / 100;
         });

         volumeBtn.addEventListener('click', () => {
             if (audio.volume > 0) {
                 audio.volume = 0;
                 volumeSlider.value = 0;
             } else {
                 audio.volume = 1;
                 volumeSlider.value = 100;
             }
         });

         /* ---------- Reset on End ---------- */
         audio.addEventListener('ended', () => {
             progressSlider.value = 0;
             playIcon.classList.remove('hidden');
             pauseIcon.classList.add('hidden');
         });

         /* ---------- Quantity Controls ---------- */
         increaseBtn.addEventListener('click', () => {
             quantity = Math.min(quantity + 1, 20);
             quantityDisplay.textContent = String(quantity).padStart(2, '0');
         });

         decreaseBtn.addEventListener('click', () => {
             quantity = Math.max(quantity - 1, 1);
             quantityDisplay.textContent = String(quantity).padStart(2, '0');
         });

         /* ---------- Utility ---------- */
         function formatTime(seconds) {
             if (!seconds || isNaN(seconds)) return '0:00';
             const m = Math.floor(seconds / 60);
             const s = Math.floor(seconds % 60).toString().padStart(2, '0');
             return `${m}:${s}`;
         }
     </script>
 @endpush
