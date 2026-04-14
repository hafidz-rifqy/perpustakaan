    <script>
        // Custom cursor logic
        const cursor = document.getElementById('cursor');
        const cursorTrail = document.getElementById('cursorTrail');
        if(cursor && cursorTrail){
            document.addEventListener('mousemove', function(e) {
                cursor.style.left = e.clientX + 'px';
                cursor.style.top = e.clientY + 'px';
                cursorTrail.style.left = e.clientX + 'px';
                cursorTrail.style.top = e.clientY + 'px';
            });
            
            document.querySelectorAll('a, button, input, textarea, select').forEach(element => {
                element.addEventListener('mouseenter', () => {
                    cursor.style.transform = 'translate(-50%, -50%) scale(2)';
                    cursor.style.borderColor = 'var(--secondary)';
                });
                element.addEventListener('mouseleave', () => {
                    cursor.style.transform = 'translate(-50%, -50%) scale(1)';
                    cursor.style.borderColor = 'white';
                });
            });
        }

        // Particle Background Logic
        const bgAnimation = document.getElementById('bgAnimation');
        if(bgAnimation){
            for (let i = 0; i < 20; i++) {
                const span = document.createElement('span');
                span.style.left = Math.random() * 100 + '%';
                span.style.top = Math.random() * 100 + '%';
                span.style.animationDelay = Math.random() * 5 + 's';
                span.style.animationDuration = Math.random() * 10 + 5 + 's';
                span.style.width = Math.random() * 30 + 10 + 'px';
                span.style.height = span.style.width;
                span.style.background = `linear-gradient(135deg, hsl(${Math.random() * 360}, 100%, 70%), hsl(${Math.random() * 360}, 100%, 50%))`;
                bgAnimation.appendChild(span);
            }
        }
    </script>
</body>
</html>
