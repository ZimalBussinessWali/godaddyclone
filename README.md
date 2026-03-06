# GoDaddy Clone - Domain Registration Platform

A fully functional GoDaddy-like domain registration platform built with PHP, CSS, and JavaScript.

## Features

✅ **Homepage with Domain Search**
- Beautiful search interface with domain search bar
- Popular domain extensions (.com, .net, .org, etc.)
- Special promotions and pricing plans

✅ **Domain Availability Checker**
- Real-time domain availability check
- Mock API with realistic results
- Displays available and taken domains

✅ **Shopping Cart**
- Add domains to cart
- View cart items
- Remove items from cart
- Checkout functionality

✅ **User Dashboard**
- View all registered domains
- See expiry dates and renewal options
- Renew domains (extends expiry by 1 year)
- Remove domains from account
- Transfer functionality (placeholder)

✅ **Responsive Design**
- Mobile-friendly layout
- Desktop optimized
- Responsive grid system

## Installation

### Requirements
- PHP 7.0 or higher
- Web server (Apache/Nginx) or PHP built-in server

### Setup

1. Clone or download the project to your web directory
2. Start your web server

**Using PHP Built-in Server:**
```bash
php -S localhost:8000
```

3. Open your browser and navigate to:
```
http://localhost:8000
```

## File Structure

```
godaddyclone/
├── index.php          # Homepage with domain search
├── cart.php           # Shopping cart page
├── dashboard.php      # User dashboard for domain management
├── README.md          # This file
├── css/
│   └── style.css      # All styles and responsive design
└── js/
    └── script.js      # Domain availability checker logic
```

## How It Works

### Domain Search
1. Enter a domain name in the search bar
2. Click "Search" or press Enter
3. System checks availability for all popular extensions
4. Results show available (green) and taken (red) domains

### Adding to Cart
1. Click "Add to Cart" on any available domain
2. Domain is added to session cart
3. Redirect to cart page

### Checkout
1. Review items in cart
2. Click "Proceed to Checkout"
3. Domains are registered and added to your account
4. Redirect to dashboard

### Domain Management
- View all registered domains
- See expiry dates and days remaining
- Renew domains (extends by 1 year)
- Remove domains from account
- Transfer button (shows coming soon alert)

## Session Management

The application uses PHP sessions to store:
- Shopping cart items
- Registered domains
- Expiry dates

## Mock Domain Database

The availability checker uses a mock database. Some domains are hardcoded as taken:
- example.com
- test.com
- sample.com
- mysite.com
- awesome.com
- cool.com
- great.com
- best.com

All other combinations will be randomly available or taken for demonstration purposes.

## Pricing

- .com: $9.99/year
- .net: $12.99/year
- .org: $10.99/year
- .io: $29.99/year
- .co: $24.99/year
- .app: $12.99/year
- .xyz: $0.99/year
- .info: $14.99/year

## Browser Support

Works on all modern browsers:
- Chrome
- Firefox
- Safari
- Edge

## Notes

- This is a demonstration project
- No real domain registration occurs
- All data is stored in PHP sessions (cleared when session ends)
- Domain availability is simulated
- Checkout process is functional but doesn't process real payments

## Future Enhancements

- Real API integration for domain checking
- User authentication system
- Database integration for persistent storage
- Email notifications
- Payment gateway integration
- Advanced domain management features

## License

This project is for educational purposes.



