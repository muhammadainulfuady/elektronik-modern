<div id="robot-container" class="w-32 h-32 mx-auto mb-6 relative">
    <svg viewBox="0 0 200 200" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
        <!-- Body -->
        <rect x="60" y="100" width="80" height="70" rx="30" fill="#3B82F6" stroke="#1E3A8A" stroke-width="4"/>
        <rect x="80" y="120" width="40" height="25" rx="5" fill="#FBBF24" stroke="#1E3A8A" stroke-width="3"/>
        <circle cx="85" cy="155" r="3" fill="#1E3A8A"/>
        <circle cx="100" cy="155" r="3" fill="#1E3A8A"/>
        <circle cx="115" cy="155" r="3" fill="#1E3A8A"/>

        <!-- Neck -->
        <rect x="90" y="90" width="20" height="15" fill="#1E3A8A"/>

        <!-- Arms -->
        <path d="M60 120 Q 40 120 35 150" stroke="#3B82F6" stroke-width="10" fill="none" stroke-linecap="round" class="arm-left transition-all duration-500 origin-[60px_120px]"/>
        <path d="M140 120 Q 160 120 165 150" stroke="#3B82F6" stroke-width="10" fill="none" stroke-linecap="round" class="arm-right transition-all duration-500 origin-[140px_120px]"/>
        
        <!-- Hands/Claws -->
        <path d="M30 150 A 10 10 0 0 0 45 150" stroke="#1E3A8A" stroke-width="4" fill="none" class="hand-left transition-all duration-500"/>
        <path d="M155 150 A 10 10 0 0 0 170 150" stroke="#1E3A8A" stroke-width="4" fill="none" class="hand-right transition-all duration-500"/>

        <!-- Head -->
        <rect x="55" y="40" width="90" height="65" rx="15" fill="#60A5FA" stroke="#1E3A8A" stroke-width="4" class="robot-head transition-all duration-300"/>
        
        <!-- Ears -->
        <rect x="40" y="60" width="15" height="25" rx="5" fill="#EF4444" stroke="#1E3A8A" stroke-width="3"/>
        <rect x="145" y="60" width="15" height="25" rx="5" fill="#EF4444" stroke="#1E3A8A" stroke-width="3"/>

        <!-- Antenna -->
        <line x1="100" y1="40" x2="100" y2="25" stroke="#1E3A8A" stroke-width="3"/>
        <circle cx="100" cy="20" r="6" fill="#EF4444" stroke="#1E3A8A" stroke-width="2"/>

        <!-- Eyes Group -->
        <g class="eyes-container">
            <!-- Left Eye -->
            <g id="eye-l" class="eye-group">
                <circle cx="82" cy="72" r="14" fill="white" stroke="#1E3A8A" stroke-width="2" class="eye-white"/>
                <circle id="pupil-l" cx="82" cy="72" r="6" fill="#1E3A8A" class="pupil transition-all duration-75"/>
                <path d="M72 72 Q 82 82 92 72" stroke="#1E3A8A" stroke-width="3" fill="none" stroke-linecap="round" class="eye-closed-path hidden"/>
            </g>
            
            <!-- Right Eye -->
            <g id="eye-r" class="eye-group">
                <circle cx="118" cy="72" r="14" fill="white" stroke="#1E3A8A" stroke-width="2" class="eye-white"/>
                <circle id="pupil-r" cx="118" cy="72" r="6" fill="#1E3A8A" class="pupil transition-all duration-75"/>
                <path d="M108 72 Q 118 82 128 72" stroke="#1E3A8A" stroke-width="3" fill="none" stroke-linecap="round" class="eye-closed-path hidden"/>
            </g>
        </g>

        <!-- Mouth -->
        <path d="M85 88 Q 100 98 115 88" stroke="#1E3A8A" stroke-width="3" fill="none" stroke-linecap="round"/>
    </svg>
</div>

<style>
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    @keyframes blink {
        0%, 96%, 100% { transform: scaleY(1); }
        98% { transform: scaleY(0.1); }
    }
    #robot-container {
        animation: floating 3s ease-in-out infinite;
    }
    .eye-group {
        animation: blink 5s infinite;
        transform-origin: center 72px;
    }
    
    /* Peek-a-boo Animation */
    .peek-a-boo .arm-left {
        transform: rotate(145deg) translate(25px, -70px);
    }
    .peek-a-boo .arm-right {
        transform: rotate(-145deg) translate(-25px, -70px);
    }
    .peek-a-boo .hand-left, .peek-a-boo .hand-right {
        opacity: 0;
    }
    
    /* Closed Eyes State (Visual) */
    .peek-a-boo .eye-white, .peek-a-boo .pupil {
        display: none;
    }
    .peek-a-boo .eye-closed-path {
        display: block;
    }
    .peek-a-boo .eye-group {
        animation: none; /* Stop blinking when closed */
    }
</style>

<script>
    (function() {
        const updatePupils = (e) => {
            if (document.querySelector('.peek-a-boo')) return;

            const pupils = [document.getElementById('pupil-l'), document.getElementById('pupil-r')];
            const container = document.getElementById('robot-container');
            if (!container) return;
            
            const rect = container.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            const angle = Math.atan2(e.clientY - centerY, e.clientX - centerX);
            const distance = Math.min(6, Math.hypot(e.clientX - centerX, e.clientY - centerY) / 40);

            const x = Math.cos(angle) * distance;
            const y = Math.sin(angle) * distance;

            pupils.forEach(pupil => {
                if (pupil) pupil.setAttribute('transform', `translate(${x}, ${y})`);
            });
        };

        const setupRobotEvents = () => {
            const passwordInputs = document.querySelectorAll('input[name*="password"]');
            const robotContainer = document.getElementById('robot-container');
            if (!robotContainer) return;

            const checkVisibilityState = () => {
                // Cari apakah ada input password yang tipenya 'text' (sedang diperlihatkan)
                const isAnyVisible = Array.from(passwordInputs).some(input => input.type === 'text');
                
                if (isAnyVisible) {
                    robotContainer.classList.add('peek-a-boo');
                } else {
                    robotContainer.classList.remove('peek-a-boo');
                }
            };

            passwordInputs.forEach(input => {
                // Monitor perubahan tipe input (saat user klik ikon mata)
                const observer = new MutationObserver(checkVisibilityState);
                observer.observe(input, { attributes: true, attributeFilter: ['type'] });
                
                // Juga cek saat input kehilangan fokus jika perlu, 
                // tapi intinya robot hanya tutup mata jika statusnya 'text'
                input.addEventListener('input', checkVisibilityState);
            });
            
            document.addEventListener('mousemove', updatePupils);
            // Cek kondisi awal
            checkVisibilityState();
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupRobotEvents);
        } else {
            setupRobotEvents();
        }
    })();
</script>
