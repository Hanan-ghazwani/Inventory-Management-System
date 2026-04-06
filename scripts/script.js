// إظهار شاشة التحميل
function showLoader() {
    const loader = document.querySelector('.loader-container');
    if (loader) loader.style.display = 'flex';
}

// إخفاء شاشة التحميل
function hideLoader() {
    const loader = document.querySelector('.loader-container');
    if (loader) loader.style.display = 'none';
}

// إظهار شاشة التحميل عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', () => {
    showLoader();

    // إخفاء شاشة التحميل  (يمكنك تعديل المدة)
    setTimeout(() => {
        hideLoader();
    }, 200); // 500ms =0.5 ثوانٍ
});

// تشغيل شاشة التحميل عند النقر على أي رابط
document.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', e => {
        const href = link.getAttribute('href');
        if (href && !href.startsWith('#') && !href.startsWith('javascript:')) { 
            // إظهار شاشة التحميل عند الروابط الخارجية فقط
            showLoader();
        }
    });
});




// تحديث الوقت والتاريخ بشكل ديناميكي
document.addEventListener("DOMContentLoaded", function () {
    function updateTimeAndDate() {
        const now = new Date(); // جلب الوقت الحالي
        const locale = "en-US"; // فرض اللغة الإنجليزية

        // تحديث الوقت
        const timeElement = document.getElementById("current-time");
        if (timeElement) {
            timeElement.innerText = now.toLocaleTimeString(locale, { 
                hour: "2-digit", 
                minute: "2-digit", 
                hour12: true, // نظام 12 ساعة
                localeMatcher: "lookup" // فرض اللغة
            });
        }

        // تحديث التاريخ
        const dateElement = document.getElementById("current-date");
        if (dateElement) {
            dateElement.innerText = now.toLocaleDateString(locale, { 
                month: "short", 
                day: "2-digit", 
                year: "numeric",
                localeMatcher: "lookup" // فرض اللغة
            });
        }
    }

    // استدعاء الوظيفة مرة عند التحميل
    updateTimeAndDate();

    // تحديث الوقت والتاريخ كل دقيقة
    setInterval(updateTimeAndDate, 60000);
});

//-----------------------زر التكبير والتصغير في الشرياط الثانوي -----------------------//

document.addEventListener("DOMContentLoaded", function () {
    const secondaryBar = document.querySelector(".secondary-bar");
    const zoomIn = document.getElementById("zoom-in");
    const zoomOut = document.getElementById("zoom-out");
  
    // استخدم هذا المتغير لضبط حجم النص داخل الشريط
    let fontSize = 14; // الحجم الافتراضي
  
    zoomIn.addEventListener("click", () => {
      fontSize += 2; // زيادة حجم الخط
      secondaryBar.style.fontSize = fontSize + "px"; // تطبيق الحجم الجديد
    });
  
    zoomOut.addEventListener("click", () => {
      if (fontSize > 10) { // منع الحجم من أن يكون صغيرًا جدًا
        fontSize -= 2; // تقليل حجم الخط
        secondaryBar.style.fontSize = fontSize + "px";
      }
    });
  });