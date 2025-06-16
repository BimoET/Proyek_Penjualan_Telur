document.addEventListener("DOMContentLoaded", () => {
  const sidebarItems = document.querySelectorAll(".dashboard-navigation .account-links, .dashboard-navigation .div");
  const searchInput = document.querySelector(".input-field");
  const searchButton = document.querySelector(".button-2");
  const rows = document.querySelectorAll(".order-history-3");
  const paginationButtons = document.querySelectorAll(".frame-4 > div");
  const prevBtn = document.querySelector(".chevron-down-wrapper");
  const nextBtn = document.querySelector(".img-wrapper");

  let currentPage = 1;
  const itemsPerPage = 5;

  // Navigasi interaktif
  sidebarItems.forEach(item => {
    item.style.cursor = "pointer";
    item.addEventListener("click", () => {
      alert(`Navigasi ke: ${item.innerText.trim()}`);
    });
  });

  // Filter pencarian
  function searchOrders() {
    const query = searchInput.value.toLowerCase();
    rows.forEach(row => {
      const match = row.innerText.toLowerCase().includes(query);
      row.style.display = match ? "block" : "none";
    });
  }

  searchButton.addEventListener("click", searchOrders);

  // Pagination manual
  function renderPage(page) {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    rows.forEach((row, index) => {
      row.style.display = index >= start && index < end ? "block" : "none";
    });

    paginationButtons.forEach((btn, index) => {
      btn.className = index + 1 === page ? "frame-5" : "frame-6";
    });

    currentPage = page;
  }

  paginationButtons.forEach((btn, index) => {
    btn.addEventListener("click", () => {
      renderPage(index + 1);
    });
  });

  prevBtn.addEventListener("click", () => {
    if (currentPage > 1) renderPage(currentPage - 1);
  });

  nextBtn.addEventListener("click", () => {
    if (currentPage < paginationButtons.length) renderPage(currentPage + 1);
  });

  // View detail interaktif
  document.querySelectorAll(".text-wrapper-21").forEach(view => {
    view.style.cursor = "pointer";
    view.addEventListener("click", () => {
      alert(`Detail Pesanan:\n${view.closest(".order-history-3").innerText}`);
    });
  });

  renderPage(currentPage);
});
