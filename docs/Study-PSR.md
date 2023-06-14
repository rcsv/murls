# About PSR
PSR(*PHP Standard Recommendations, PHP標準勧告*)は、PHP-FIG(*The PHP Framework Interop Group, PHPフレームワーク相互運用グループ*)が策定しているPHPの規約です。
PSRを定めることによってフレームワークやライブラリ間での相互連携を可能とし、PHP(とそのエコシステム)を発展させるために存在しています。
PHPの公式団体ではないところからの策定した標準なので、必ず守らなければならない、という必要はない。

内容は、RFC 2119 の記法に従って下記の要素で記載される
- MUST
- MUST NOT
- REQUIRED
- SHALL
- SHALL NOT
- SHOULD
- SHOULD NOT
- RECOMMENDED
- MAY
- OPTIONAL

| No | Status         | Title                       | Description |
|----|----------------|-----------------------------|-------------|
| 0  | **Deprecated** | Autoloading Standard        | PSR-4 is now recommended as an alternative. |
| 1  | Accepted       | Basic Coding Standard       | This section of the standard comprises what should be considered the standard coding elements that are required to ensure a high level of technical interoperability between shared PHP code. |
| 2  | **Deprecated** | Coding Style Guide          | PSR-12 is now recommended as an alternative. |
| 3  | Accepted       | Logger Interface            | This document describes a common interface for logging libraries. |
| 4  | Accepted       | Autoloader                  | This PSR describes a specification for autoloading classes from file paths. It is fully interoperable, and can be used in addition to any other autoloading specification, including PSR-0. This PSR also describes where to place files that will be autoloaded according to the specification. |
| 5  | Draft          | PHPDoc                      | ... |
| 6  | Accepted       | Caching Interface           | Caching is a common way to improve the performance of any project, making caching libraries one of the most common features of many frameworks and libraries. This has lead to a situation where many libraries roll their own caching libraries, with various levels of functionality. These differences are causing developers to have to learn multiple systems which may or may not provide the functionality they need. In addition, the developers of caching libraries themselves face a choice between only supporting a limited number of frameworks or creating a large number of adapter classes. |
| 7  | Accepted       | HTTP message interfaces     | This document describes common interfaces for representing HTTP messages as described in RFC 7230 and RFC 7231, and URIs for use with HTTP messages as described in RFC 3986. |
| 8  | Abandoned      | Mutually Assured Hug        | This standard establishes a common way for objects to express mutual appreciation and support by hugging. This allows objects to support each other in a constructive fashion, furthering cooperation between different PHP projects. |
| 9  | Abandoned      | Security Advisories         | |
| 10 | Abandoned      | Security Reporting Process  | |
| 11 | Accepted       | Container Interface         | |
| 12 | Accepted       | Extended Coding Style Guide | |
| 13 | Accepted       | Hypermedia Links            | |
| 14 | Accepted       | Event Dispatcher            | |
| 15 | Accepted       | HTTP Handler                | |
| 16 | Accepted       | Simple Cache                | PSR-6 ...? |
| 17 | Accepted       | HTTP Factories              | |
| 18 | Accepted       | HTTP Client                 | |
| 19 | Draft          | PHPDoc tags                 | |
| 20 | Accepted       | Clock                       | |
| 21 | Draft          | Internationalization        | |
| 22 | Draft          | Application Tracing         | |


## See Also:
- [PSR](https://www.php-fig.org/psr/)
- [FIG-Standards](https://github.com/php-fig/fig-standards)
- [About PSR](https://qiita.com/tuuuuuuken/items/cd5f84ea0aa4374b0a91)
