document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('searchForm');
    const domainInput = document.getElementById('domainInput');
    const resultsArea = document.getElementById('resultsArea');
    const resultCard = document.getElementById('resultCard');
    const searchBtn = document.getElementById('searchBtn');
    const loader = searchBtn.querySelector('.loader');
    const btnText = searchBtn.querySelector('.btn-text');

    if (searchForm) {
        searchForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const domain = domainInput.value.trim();
            if (!domain) return;

            // Start search animation
            btnText.style.display = 'none';
            loader.style.display = 'inline-block';
            searchBtn.disabled = true;

            try {
                const response = await fetch(`domain_check.php?domain=${encodeURIComponent(domain)}`);
                const data = await response.json();

                // Show results
                resultsArea.style.display = 'block';
                resultCard.innerHTML = `
                    <div class="domain-info">
                        <span class="status ${data.available ? 'available' : 'unavailable'}">
                            ${data.available ? 'Available' : 'Taken'}
                        </span>
                        <h2>${data.domain}</h2>
                        <p>${data.available ? 'This domain is ready for you!' : 'This domain is already registered.'}</p>
                    </div>
                    <div class="registration-action">
                        <div class="price">${data.available ? '$9.99/yr' : ''}</div>
                        ${data.available ? 
                            `<form action="domain_register.php" method="POST">
                                <input type="hidden" name="domain" value="${data.domain}">
                                <button type="submit" class="btn-register">Buy It Now</button>
                            </form>` : 
                            `<button class="btn-register" style="background: #ccc; cursor: not-allowed;" disabled>Sold</button>`
                        }
                    </div>
                `;

                // Scroll to result
                resultsArea.scrollIntoView({ behavior: 'smooth', block: 'center' });

            } catch (error) {
                console.error('Error checking domain:', error);
                alert('Something went wrong. Please try again.');
            } finally {
                btnText.style.display = 'inline-block';
                loader.style.display = 'none';
                searchBtn.disabled = false;
            }
        });
    }

    // Modal/Form toggle animations
    const authForms = document.querySelectorAll('.auth-container');
    authForms.forEach(form => {
        form.style.opacity = '0';
        form.style.transform = 'translateY(20px)';
        setTimeout(() => {
            form.style.transition = 'all 0.6s ease';
            form.style.opacity = '1';
            form.style.transform = 'translateY(0)';
        }, 100);
    });
});
