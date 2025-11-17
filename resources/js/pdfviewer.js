document.addEventListener('DOMContentLoaded', () => {

    // --- DOM Elements ---
    // We first get the main container to read the data-pdf-url attribute
    const bookViewerContainer = document.getElementById('book-viewer-container');

    // Exit if this container isn't on the page (protection for other pages)
    if (!bookViewerContainer) {
        return;
    }

    const pdfUrl = bookViewerContainer.dataset.pdfUrl; // Read URL from data- attribute

    const bookContainer = document.getElementById('book');
    const navControls = document.getElementById('navigation-controls');
    const loadingSpinner = document.getElementById('loading-spinner');
    const pageContainer = document.getElementById('page-container');

    const canvasLeft = document.getElementById('pdf-canvas-left');
    const canvasRight = document.getElementById('pdf-canvas-right');
    const ctxLeft = canvasLeft.getContext('2d');
    const ctxRight = canvasRight.getContext('2d');

    const pageNumLeftSpan = document.getElementById('page-num-left');
    const pageNumRightSpan = document.getElementById('page-num-right');
    const pageCountSpan = document.getElementById('page-count');

    const prevButton = document.getElementById('prev-page');
    const nextButton = document.getElementById('next-page');
    const prevClickable = document.getElementById('prev-page-clickable');
    const nextClickable = document.getElementById('next-page-clickable');

    // --- PDF State ---
    let pdfDoc = null;
    let totalPages = 0;
    let currentDisplayNum = 0; // This will track the left page of the spread
    let isRendering = false;

    // --- Swipe/Drag State ---
    let isDragging = false;
    let dragStartX = 0;
    const dragThreshold = 100; // Min pixels to swipe to turn page

    // --- Functions ---

    /**
     * Clears a canvas, making it blank.
     */
    function clearCanvas(ctx, canvas) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        canvas.style.backgroundColor = '#f3f4f6'; // bg-gray-100
        canvas.style.visibility = 'hidden'; // Hide blank canvases
        canvas.style.height = 'auto';
        canvas.style.width = 'auto';
    }

    /**
     * Renders a specific PDF page onto a given canvas.
     */
    async function renderPage(pageNum, canvas, ctx) {
        if (isRendering) return;
        isRendering = true;

        if (pageNum <= 0 || pageNum > totalPages) {
            clearCanvas(ctx, canvas);
            isRendering = false;
            return;
        }

        canvas.style.visibility = 'visible';
        canvas.style.backgroundColor = '#ffffff';

        try {
            const page = await pdfDoc.getPage(pageNum);
            const containerHeight = pageContainer.clientHeight;
            const viewportDefault = page.getViewport({ scale: 1.0 });
            const scale = containerHeight / viewportDefault.height;
            const viewport = page.getViewport({ scale: scale });

            canvas.height = viewport.height;
            canvas.width = viewport.width;
            canvas.style.height = `${viewport.height}px`;
            canvas.style.width = `${viewport.width}px`;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            await page.render(renderContext).promise;
        } catch (error) {
            console.error('Error rendering page:', error);
        }
        isRendering = false;
    }

    /**
     * Main function to render the two-page book view.
     */
    async function renderBookView(num) {
        if (num < 0) num = 0;
        currentDisplayNum = num;
        await renderPage(num, canvasLeft, ctxLeft);
        await renderPage(num + 1, canvasRight, ctxRight);
        updateUI();
    }

    /**
     * Updates page numbers and button states.
     */
    function updateUI() {
        const leftNum = currentDisplayNum;
        const rightNum = currentDisplayNum + 1;
        pageNumLeftSpan.textContent = leftNum > 0 ? leftNum : '-';
        pageNumRightSpan.textContent = rightNum <= totalPages ? rightNum : '-';
        prevButton.disabled = currentDisplayNum <= 0;
        prevClickable.style.display = currentDisplayNum <= 0 ? 'none' : 'block';
        nextButton.disabled = currentDisplayNum + 2 > totalPages;
        nextClickable.style.display = currentDisplayNum + 2 > totalPages ? 'none' : 'block';
    }

    // --- Navigation Functions ---
    function goToNextPage() {
        if (isRendering || currentDisplayNum + 2 > totalPages) return;
        renderBookView(currentDisplayNum + 2);
    }
    function goToPrevPage() {
        if (isRendering || currentDisplayNum <= 0) return;
        renderBookView(currentDisplayNum - 2);
    }

    // --- Event Listeners ---
    prevButton.addEventListener('click', goToPrevPage);
    nextButton.addEventListener('click', goToNextPage);
    prevClickable.addEventListener('click', goToPrevPage);
    nextClickable.addEventListener('click', goToNextPage);

    // --- Swipe/Drag Listeners ---
    const swipeContainer = document.getElementById('book-viewer-container');
    function onDragStart(e) {
        if (isRendering) return;
        isDragging = true;
        dragStartX = e.pageX || e.touches[0].pageX;
        swipeContainer.style.cursor = 'grabbing';
    }
    function onDragMove(e) {
        if (!isDragging) return;
        e.preventDefault(); // Prevent text selection
    }
    function onDragEnd(e) {
        if (!isDragging) return;
        isDragging = false;
        swipeContainer.style.cursor = 'default';
        const dragEndX = e.pageX || e.changedTouches[0].pageX;
        const dragDistance = dragEndX - dragStartX;
        if (Math.abs(dragDistance) > dragThreshold) {
            if (dragDistance > 0) goToPrevPage(); // Swiped right
            else goToNextPage(); // Swiped left
        }
    }

    // Mouse events
    swipeContainer.addEventListener('mousedown', onDragStart);
    swipeContainer.addEventListener('mousemove', onDragMove);
    swipeContainer.addEventListener('mouseup', onDragEnd);
    swipeContainer.addEventListener('mouseleave', onDragEnd);
    // Touch events
    swipeContainer.addEventListener('touchstart', onDragStart, { passive: false });
    swipeContainer.addEventListener('touchmove', onDragMove, { passive: false });
    swipeContainer.addEventListener('touchend', onDragEnd);

    // --- Initial Load ---
    // Make sure to include the PDF.js library *before* this script
    // (We'll do that in the Blade file)
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

    pdfjsLib.getDocument(pdfUrl).promise.then(pdfDoc_ => {
        pdfDoc = pdfDoc_;
        totalPages = pdfDoc.numPages;
        pageCountSpan.textContent = totalPages;
        loadingSpinner.style.display = 'none';
        bookContainer.classList.remove('hidden');
        bookContainer.classList.add('flex');
        navControls.classList.remove('hidden');
        navControls.classList.add('flex');
        renderBookView(0); // Start with cover page
    }).catch(err => {
        console.error('Error loading PDF:', err);
        loadingSpinner.textContent = 'Error loading book. Please try again.';
    });

}); // End of DOMContentLoaded
