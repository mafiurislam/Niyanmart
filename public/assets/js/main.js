/**
 * NAYAN MART – Main JavaScript Client
 */

document.addEventListener('DOMContentLoaded', () => {
  initSearchAutocomplete();
  initCategoryDropdown();
  initPincodeChecker();
  initVariantSelector();
  initQuantityControls();
  initWishlistToggle();
  initMobileDrawer();
  initToast();
});

// Toast notification helper
function showToast(message, type = 'success') {
  let toastContainer = document.getElementById('toast-container');
  if (!toastContainer) {
    toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    toastContainer.style.cssText = 'position: fixed; bottom: 80px; right: 16px; left: 16px; max-width: 400px; margin: 0 auto; z-index: 9999; display: flex; flex-direction: column; gap: 8px;';
    document.body.appendChild(toastContainer);
  }

  const toast = document.createElement('div');
  const bg = type === 'success' ? '#0f7a3f' : (type === 'error' ? '#dc2626' : '#f59e0b');
  toast.style.cssText = `background: ${bg}; color: #fff; padding: 12px 18px; border-radius: 10px; font-size: 13.5px; font-weight: 600; box-shadow: 0 10px 25px rgba(0,0,0,0.25); display: flex; align-items: center; gap: 10px; animation: slideIn 0.3s ease forwards;`;
  toast.innerHTML = `<i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-info-circle-fill'}" style="font-size: 16px;"></i> <span>${message}</span>`;
  
  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(10px)';
    toast.style.transition = 'all 0.3s ease';
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}

// 1. Search Bar Autocomplete (Desktop & Mobile)
function initSearchAutocomplete() {
  const pairs = [
    { input: document.getElementById('main-search-input'), dropdown: document.getElementById('search-autocomplete-dropdown') },
    { input: document.getElementById('mobile-search-input'), dropdown: document.getElementById('mobile-search-dropdown') }
  ];

  pairs.forEach(({ input, dropdown }) => {
    if (!input || !dropdown) return;

    let debounceTimer;

    input.addEventListener('input', (e) => {
      clearTimeout(debounceTimer);
      const query = e.target.value.trim();

      if (query.length < 2) {
        dropdown.style.display = 'none';
        dropdown.innerHTML = '';
        return;
      }

      debounceTimer = setTimeout(() => {
        fetch(`/search-suggestions?term=${encodeURIComponent(query)}`)
          .then(res => res.json())
          .then(data => {
            if (data && data.length > 0) {
              dropdown.innerHTML = data.map(item => `
                <a href="/product/${item.slug}" class="autocomplete-item">
                  <img src="${item.image || '/assets/images/products/mother-dairy-curd.png'}" alt="${item.name}" onerror="this.onerror=null;this.src='/assets/images/products/mother-dairy-curd.png';">
                  <div style="flex:1; min-width:0;">
                    <div class="autocomplete-title" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${item.name}</div>
                    <div style="font-size: 11px; color: #64748b;">${item.weight || ''}</div>
                  </div>
                  <div class="autocomplete-price" style="font-weight:700; color:#0f7a3f;">₹${parseFloat(item.selling_price).toFixed(0)}</div>
                </a>
              `).join('');
              dropdown.style.display = 'block';
            } else {
              dropdown.innerHTML = '<div style="padding: 12px; text-align: center; color: #64748b; font-size: 13px;">No matching products found.</div>';
              dropdown.style.display = 'block';
            }
          })
          .catch(err => console.error('Search error', err));
      }, 200);
    });

    document.addEventListener('click', (e) => {
      if (!input.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
      }
    });
  });
}

// 2. Categories Dropdown Toggle
function initCategoryDropdown() {
  const trigger = document.getElementById('all-categories-trigger');
  const menu = document.getElementById('categories-dropdown-menu');
  if (!trigger || !menu) return;

  trigger.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('show');
  });

  document.addEventListener('click', (e) => {
    if (!trigger.contains(e.target) && !menu.contains(e.target)) {
      menu.classList.remove('show');
    }
  });
}

// 3. PIN Code Delivery Checker
function initPincodeChecker() {
  const btn = document.getElementById('btn-check-pincode');
  const input = document.getElementById('pincode-input');
  const resultBox = document.getElementById('pincode-result');

  if (!btn || !input || !resultBox) return;

  btn.addEventListener('click', () => {
    const pin = input.value.trim();
    if (pin.length !== 6 || isNaN(pin)) {
      resultBox.innerHTML = '<span style="color: #dc2626;"><i class="bi bi-x-circle"></i> Please enter a valid 6-digit PIN code.</span>';
      return;
    }

    btn.disabled = true;
    btn.innerText = 'Checking...';

    fetch(`/check-pincode?pincode=${pin}`)
      .then(res => res.json())
      .then(data => {
        btn.disabled = false;
        btn.innerText = 'Check';
        if (data.deliverable) {
          resultBox.innerHTML = `<span style="color: #0f7a3f; font-weight: 500;"><i class="bi bi-geo-alt-fill"></i> ${data.message}</span>`;
        } else {
          resultBox.innerHTML = `<span style="color: #dc2626;"><i class="bi bi-exclamation-triangle-fill"></i> ${data.message}</span>`;
        }
      })
      .catch(() => {
        btn.disabled = false;
        btn.innerText = 'Check';
        resultBox.innerHTML = '<span style="color: #dc2626;">Error checking delivery PIN code. Please try again.</span>';
      });
  });
}

// 4. Product Variant Selector (Weight / Pack Pills)
function initVariantSelector() {
  const pills = document.querySelectorAll('.weight-pill-btn');
  const priceDisplay = document.getElementById('selected-product-price');
  const mrpDisplay = document.getElementById('selected-product-mrp');
  const savingsDisplay = document.getElementById('selected-product-savings');
  const weightInput = document.getElementById('selected-weight-input');

  if (!pills.length) return;

  pills.forEach(pill => {
    pill.addEventListener('click', () => {
      pills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');

      const price = parseFloat(pill.dataset.price);
      const mrp = parseFloat(pill.dataset.mrp);
      const weight = pill.dataset.weight;

      if (priceDisplay) priceDisplay.innerText = '₹' + price.toFixed(0);
      if (mrpDisplay) mrpDisplay.innerText = '₹' + mrp.toFixed(0);
      if (savingsDisplay) {
        const save = mrp - price;
        savingsDisplay.innerText = save > 0 ? `Save ₹${save.toFixed(0)}` : '';
      }
      if (weightInput) weightInput.value = weight;

      if (pill.dataset.image) {
        const mainImg = document.getElementById('main-product-display');
        if (mainImg) {
          mainImg.style.opacity = '0.3';
          mainImg.src = pill.dataset.image;
          setTimeout(() => { mainImg.style.opacity = '1'; }, 150);
        }
      }
    });
  });
}

// 5. Quantity Controls
function initQuantityControls() {
  document.querySelectorAll('.qty-counter').forEach(counter => {
    const decBtn = counter.querySelector('.qty-dec');
    const incBtn = counter.querySelector('.qty-inc');
    const input = counter.querySelector('.qty-input');

    if (decBtn && incBtn && input) {
      decBtn.addEventListener('click', () => {
        let val = parseInt(input.value) || 1;
        if (val > 1) {
          input.value = val - 1;
          input.dispatchEvent(new Event('change'));
        }
      });

      incBtn.addEventListener('click', () => {
        let val = parseInt(input.value) || 1;
        if (val < 50) {
          input.value = val + 1;
          input.dispatchEvent(new Event('change'));
        }
      });
    }
  });
}

// 6. Wishlist Toggle
function initWishlistToggle() {
  document.querySelectorAll('.btn-wishlist').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const productId = btn.dataset.productId;
      if (!productId) return;

      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

      fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token || '',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ product_id: productId })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          btn.classList.toggle('active', data.added);
          const icon = btn.querySelector('i');
          if (icon) {
            icon.className = data.added ? 'bi bi-heart-fill' : 'bi bi-heart';
          }
          document.querySelectorAll('.header-wishlist-count').forEach(el => {
            el.innerText = data.wishlist_count;
          });
          showToast(data.message);
        }
      })
      .catch(err => console.error('Wishlist error', err));
    });
  });
}

// AJAX Add to Cart (Synchronizes desktop, mobile app header, and floating cart bar)
window.addToCartAjax = function(productId, weight = null, quantity = 1) {
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  fetch('/cart/add', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token || '',
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      product_id: productId,
      weight: weight,
      quantity: quantity
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      document.querySelectorAll('.header-cart-count').forEach(el => {
        el.innerText = data.cart_count;
      });

      document.querySelectorAll('.header-cart-total').forEach(el => {
        el.innerText = '₹' + data.cart_total;
      });

      const floatingCart = document.getElementById('mobile-floating-cart');
      if (floatingCart) {
        if (data.cart_count > 0) {
          floatingCart.classList.add('visible');
        } else {
          floatingCart.classList.remove('visible');
        }
      }

      showToast(data.message);
    }
  })
  .catch(err => console.error('Cart error', err));
};

// 7. Mobile App Drawer & Touch Navigation
function initMobileDrawer() {
  const toggleBtn = document.getElementById('mobile-drawer-toggle');
  const drawer = document.getElementById('mobile-nav-drawer');
  const overlay = document.getElementById('mobile-drawer-overlay');
  const closeBtn = document.getElementById('mobile-drawer-close');

  if (!drawer || !overlay) return;

  function openDrawer() {
    drawer.classList.add('open');
    overlay.classList.add('active');
    drawer.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    drawer.classList.remove('open');
    overlay.classList.remove('active');
    drawer.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  if (toggleBtn) toggleBtn.addEventListener('click', openDrawer);
  if (overlay) overlay.addEventListener('click', closeDrawer);
  if (closeBtn) closeBtn.addEventListener('click', closeDrawer);

  // Swipe gesture to close drawer on mobile touch
  let touchStartX = 0;
  let touchEndX = 0;

  drawer.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });

  drawer.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    if (touchStartX - touchEndX > 50) {
      // Swiped left
      closeDrawer();
    }
  }, { passive: true });
}

function initToast() {
  const style = document.createElement('style');
  style.innerHTML = `
    @keyframes slideIn {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  `;
  document.head.appendChild(style);
}
