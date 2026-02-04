<p align="center">
  <img src="http://www.smim.com.my/images/top_01_01.jpg" alt="SMI IPOS Logo">
  <h1 align="center">SMI IPOS (Intelligent Production Online System)</h1>
  <p align="center">
    A comprehensive production monitoring and online system built with Laravel
  </p>
</p>

<p align="center">
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Laravel Version">
  </a>
</p>

## About SMI IPOS

SMI IPOS (Intelligent Production Online System) is a comprehensive manufacturing execution system (MES) designed to monitor, analyze, and optimize production processes. Built on the Laravel framework, it provides real-time visibility into production lines, equipment performance, and overall plant efficiency.

### Key Features

- **Real-time Production Monitoring**: Track production lines and work centers in real-time
- **OEE Calculation**: Automatic Overall Equipment Effectiveness calculation
- **Downtime Tracking**: Monitor and analyze equipment downtime events
- **Production Analytics**: Comprehensive reporting and analytics for production data
- **OPC Integration**: Seamless integration with OPC servers for live data acquisition
- **User Management**: Role-based access control for different user levels
- **Shift Management**: Support for multiple shift patterns and scheduling
- **Quality Control**: Track production quality metrics and reject reasons

### Technology Stack

- **Backend**: Laravel PHP Framework
- **Frontend**: Vue.js, Bootstrap
- **Database**: MySQL
- **Real-time**: Laravel Echo, WebSockets
- **OPC Integration**: OPC DA/AE/HDA
- **Deployment**: Docker, Nginx

## Getting Started

### Prerequisites

- PHP 7.4+ / 8.0+
- Composer
- Node.js & NPM
- MySQL 5.7+ / MariaDB 10.3+
- OPC Server (for production data acquisition)

### Installation

1. Clone the repository:
   ```bash
   git clone [repository-url]
   cd smi_ipos
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   npm run dev
   ```

4. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your database settings in `.env`

6. Run database migrations:
   ```bash
   php artisan migrate --seed
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

8. Access the application at `http://localhost:8000`

## Documentation

For detailed documentation, please refer to the [Documentation Wiki](https://github.com/your-org/smi_ipos/wiki).

## License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## About Laravel

This project is built using the [Laravel framework](https://laravel.com/). Laravel is a web application framework with expressive, elegant syntax.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
