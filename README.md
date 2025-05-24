# PHP Refactoring Assessment

This project demonstrates a modern, SOLID, and testable refactoring of an order processing system using the Flight PHP micro-framework and the latest PHP 8.4 features.

## Key Refactoring Highlights

- **Domain Models**: `Order`, `OrderItem`, and `Customer` are immutable value objects using `public readonly` properties and constructor property promotion.
- **SOLID Services**: Business logic is split into services (`OrderCalculatorService`, `DiscountService`, `EmailService`) for single responsibility and testability.
- **Strategy Pattern**: Discount logic uses the strategy pattern with individual rule classes for extensibility and open/closed compliance.
- **Modern PHP**: Uses features like constructor property promotion, `readonly` properties, and strict typing throughout.
- **PSR-12 & Static Analysis**: Code style and static analysis are enforced with PHP_CodeSniffer and PHPStan.
- **Tests**: PHPUnit tests cover all core logic and orchestration.

## Getting Started

### Install Dependencies

```bash
composer install
```

### Run the Development Server

```bash
composer start
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

### Run Tests

```bash
composer test
```

### Run Static Analysis

```bash
composer analyse
```

### Check Code Style

```bash
composer cs:check
```

### Run All Quality Checks

```bash
composer quality
```
