# DragonGod Phone

DragonGod Phone 是一个以原创手机品牌为主题的多页面电商展示网站。项目包含产品介绍、分类浏览、搜索、账号页面，以及二手手机发布和购买流程的前端演示。

## 功能

- **品牌首页**：展示 Aether Fold One 的产品故事、设计、性能、配件和购买入口。
- **产品与分类页面**：浏览手机及穿戴设备、电脑、平板、音频、路由器等产品分类。
- **产品详情与搜索**：查看产品介绍，并按关键词搜索站内产品和卖家商品。
- **账号页面**：提供注册、登录、帮助和隐私等页面。
- **卖家与购物流程**：包含二手手机发布、商品详情、购物车及购买流程。
- **交互体验**：使用 JavaScript 实现页面交互、购物车状态和本地演示数据。

## 技术栈

- HTML、CSS、原生 JavaScript
- PHP：表单处理及部分搜索、商品和交易接口
- MySQL：部分账号及商品接口使用
- JSON、浏览器 `localStorage`：演示数据和购物车状态

项目没有前端构建步骤或 npm 依赖。

## 本地运行

### 浏览页面

安装 PHP，并在项目根目录运行：

```powershell
php -S 127.0.0.1:8000
```

然后在浏览器打开：

```text
http://127.0.0.1:8000/HTML/HomePages/index.html
```

Windows 用户也可以运行根目录中的 `start-project.bat`。该脚本会启动 PHP 内置服务器并打开首页；需要先安装 PHP 并将 `php.exe` 加入 `PATH`。

### 启用数据库相关功能

部分注册、登录和卖家商品处理接口依赖 MySQL。运行这些功能前，请先检查并配置 `PHP/db_config.php`、`PHP/db_connect.php` 及数据库表结构。

> **注意：** `MySQL/` 中的 SQL 文件和 PHP 接口目前使用的数据库名称、表名及字段尚未完全统一，不能直接假设导入 SQL 后所有后端功能即可运行。`MySQL/data_sec.sql` 含有删除现有表的语句；仅在确认数据可丢弃的测试数据库中执行。

## 项目结构

```text
.
├── CSS/                 页面样式
├── HTML/
│   ├── HomePages/       首页及产品分类页面
│   ├── DetailIntroduction/ 产品详情页面
│   ├── Login&Registration/ 账号与帮助页面
│   ├── SellPage(addcar)/   购买与购物车页面
│   └── Sell_Product/    卖家商品页面
├── JS/                  页面交互、目录、搜索与演示数据
├── PHP/                 PHP 接口与数据处理
├── MySQL/               数据库 SQL 示例
├── Recourses/           图片、图标及其他静态资源
├── data/                JSON 和文本演示数据
└── start-project.bat    Windows 本地启动脚本
```

## 说明

这是一个演示性质的项目。部分页面和购物车可使用浏览器本地数据浏览；需要 PHP 或 MySQL 的操作则取决于对应服务及数据库配置。
