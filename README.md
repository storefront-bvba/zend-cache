# Storefront's adaptation of Zend Framework Cache 1

> **Deprecated (2026-10-16): use [`storefront/cache`](https://github.com/storefront-bvba/cache) instead.** It is the
> cache of the Storefront platform as a package of its own (Redis via phpredis, atomic saves and cleans by tag), used by
> the platform and the Storefront ERP. This package gets no more changes.

## Changes made vs the original `zf1/zend-cache` package.

1. Minimum PHP version increased to 7.4
2. Dependencies removed:

- Zend_Exception