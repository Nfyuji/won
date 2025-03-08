<!-- includes/footer.php -->
<footer class="site-footer">


    <?php if (!empty($winner_name)): ?>
        <!-- عرض النافذة المنبثقة بعد اختيار الفائز -->
        <div class="modal" id="winnerModal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>الفائز هو:</h2>
                <canvas id="circularLoader" width="200" height="200"></canvas>
                <div class="winner" id="winnerInfo" style="display: none;">
                    <p><?php echo $winner_name; ?></p>
                    <p><?php echo $winner_email; ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // عرض نافذة الفائز عند الضغط على الزر
        window.onload = function() {
            <?php if (!empty($winner_name)): ?>
                var modal = document.getElementById("winnerModal");
                modal.style.display = "flex";

                // الحصول على عنصر canvas والسياق
                var canvas = document.getElementById("circularLoader");
                var ctx = canvas.getContext("2d");

                var al = 100; // النسبة المئوية للدائرة (تبدأ من 100%)
                var start = 4.72; // نقطة البداية للدائرة
                var cw = canvas.width / 2; // مركز العرض
                var ch = canvas.height / 2; // مركز الارتفاع
                var diff;

                function progressSim() {
                    diff = ((al / 100) * Math.PI * 2 * 10).toFixed(2); // حساب الزاوية
                    ctx.clearRect(0, 0, canvas.width, canvas.height); // مسح canvas

                    ctx.lineWidth = 17; // سماكة الخط
                    ctx.fillStyle = "#4285f4"; // لون النص
                    ctx.strokeStyle = "#4285f4"; // لون الدائرة
                    ctx.textAlign = "center"; // توسيط النص
                    ctx.font = "28px monospace"; // حجم الخط

                    // رسم النسبة المئوية
                    ctx.fillText(al + '%', cw, ch + 5, cw + 12);

                    // رسم الدائرة
                    ctx.beginPath();
                    ctx.arc(cw, ch, 75, start, diff / 10 + start, false);
                    ctx.stroke();

                    // تقليل النسبة المئوية
                    if (al <= 0) {
                        clearTimeout(sim); // إيقاف العد التنازلي
                        document.getElementById("winnerInfo").style.display = "block"; // عرض اسم الفائز
                        return;
                    }
                    al--;
                }

                // بدء العد التنازلي
                var sim = setInterval(progressSim, 50);
            <?php endif; ?>

            // إغلاق النافذة المنبثقة عند الضغط على زر الإغلاق
            var closeBtn = document.getElementsByClassName("close")[0];
            closeBtn.onclick = function() {
                var modal = document.getElementById("winnerModal");
                modal.style.display = "none";
            }

            // إغلاق النافذة المنبثقة عند الضغط في أي مكان خارج النافذة
            window.onclick = function(event) {
                var modal = document.getElementById("winnerModal");
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    </script>
        
</footer>
<!-- تضمين ملفات الجافاسكريبت -->
<script src="js/loader.js"></script>
