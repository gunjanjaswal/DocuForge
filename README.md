<div align="center">

# 📄 Paperpane

### Embed PDFs directly inside your WordPress posts and pages

A lightweight PDF embed plugin with a Gutenberg block **and** a shortcode. It uses the browser's own PDF viewer, so there's no bulky library to load and nothing ever leaves your server.

[![Version](https://img.shields.io/badge/version-1.2.0-2563eb.svg?style=for-the-badge)](https://github.com/gunjanjaswal/Paperpane/releases)
[![WordPress](https://img.shields.io/badge/WordPress-6.0%E2%80%937.1-21759b.svg?style=for-the-badge&logo=wordpress&logoColor=white)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777bb4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-GPL--2.0%2B-3fb950.svg?style=for-the-badge)](LICENSE)

</div>

---

## ✨ What it does

Most PDF embeds either drop a plain download link, or pull in a megabyte of JavaScript to render something the browser already renders perfectly well. Paperpane takes the lighter road: it points the browser at your file and lets its built-in viewer do the work. You pick a PDF, set a height, and your readers scroll through it without ever leaving the page.

No account, no API key, no external request. The file stays on your own site.

## 🎯 Features

| | |
|---|---|
| 🧱 **Block editor** | A **Paperpane** block with a live preview while you set it up. |
| 🔤 **Shortcode** | `[paperpane]` for the classic editor, widgets, or template files. |
| 📐 **Adjustable height** | Set the viewer to any pixel height you like. |
| 🛠️ **Toolbar toggle** | Show or hide the viewer's built-in toolbar. |
| 🖥️ **Full-width read** | Fits the page to the viewer width and hides the thumbnail sidebar. |
| 📱 **Responsive** | Fits phones and wide desktop layouts out of the box. |
| 🌍 **Translation ready** | All strings are wrapped, with a translation template included. |
| 🔒 **Safe output** | Everything is escaped and sanitised the WordPress way. |

## 📦 Installation

**From your dashboard**

1. Go to **Plugins → Add New → Upload Plugin**.
2. Choose `paperpane.zip` and click **Install Now**.
3. Click **Activate**.

**From this repository**

1. Download the latest release, or clone the repo.
2. Put the folder in `wp-content/plugins/` as `paperpane`.
3. Activate **Paperpane** on the Plugins screen.

There is no settings page, so you can start embedding right away.

## 🚀 How to use

### Embed a PDF with the block

1. Edit a post or page.
2. Click the **+** block inserter and search for **Paperpane**.
3. Add the block, then click **Upload** or **Media Library** and pick your PDF.
4. In the block sidebar, set the **viewer height**, show or hide the **toolbar**, and add an **accessible title** if you want one.
5. Use **Replace PDF** in the block toolbar any time you need to swap the file.
6. Publish. The PDF appears inline, fitted to your content width.

> **Tip:** To run the viewer edge to edge, select the block and choose **Wide width** or **Full width** from the block toolbar.

### Embed a PDF with the shortcode

Reach for the shortcode in the classic editor, a widget, or a template file.

Embed a file from the Media Library by its attachment ID:

```text
[paperpane id="123"]
```

Embed any PDF by URL, taller and with the toolbar hidden:

```text
[paperpane url="https://example.com/files/report.pdf" height="800" toolbar="0"]
```

Call it from a template:

```php
<?php echo do_shortcode( '[paperpane id="123"]' ); ?>
```

> The former `[pdf-embed-forge]` and `[pdf-forge]` shortcodes still work as aliases, so anything built before the rename keeps running.

### Shortcode attributes

| Attribute  | Description                                                   | Default |
|------------|---------------------------------------------------------------|---------|
| `id`       | Media Library attachment ID of the PDF.                       | —       |
| `url`      | Direct URL to a PDF (used when no `id` is given).             | —       |
| `height`   | Viewer height in pixels.                                      | `600`   |
| `toolbar`  | `1` shows the viewer toolbar, `0` hides it.                   | `1`     |
| `title`    | Accessible title for the viewer, read out by screen readers. | —       |

### Finding a PDF's attachment ID

Open **Media → Library**, click the PDF, and read the `item=` number in the address bar. Or copy the file URL and use the `url` attribute instead.

## ❓ FAQ

**Does it work on mobile?**
Yes. On phones, where inline PDF frames are cramped (and unreliable in iOS Safari), the embed shows the PDF's first page with a "View full screen" button that opens it in the device's native viewer. The preview image is the one WordPress generates on upload; where the host can't make one, a document icon is shown instead. Larger screens get the inline viewer.

**Can I hide the toolbar or the pages sidebar?**
The thumbnail sidebar is hidden automatically. To hide the toolbar too, set `toolbar="0"` or flip the toggle in the block sidebar. Chromium-based browsers honour it; others show their own controls.

**Can I embed a PDF hosted somewhere else?**
Yes, pass its full URL to the `url` attribute. Bear in mind some hosts block being embedded in a frame, which is their setting, not the plugin's.

**Where do my PDFs go?**
Nowhere new. The browser loads the file straight from your site. Nothing is uploaded to or routed through any outside service.

## 🧩 WordPress.org ready

Built to the [WordPress.org plugin guidelines](https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/): a proper `readme.txt`, a unique prefix, escaped output, sanitised input, a bundled translation template, and GPL-2.0-or-later licensing, with no external calls. It passes the official [Plugin Check](https://wordpress.org/plugins/plugin-check/) plugin.

## 🛠️ Development

The block is written in plain `wp.element` calls with no build step, so the source in `assets/js/block.js` is exactly what runs. Clone the repo into `wp-content/plugins/paperpane` and start editing.

```text
paperpane/
├── paperpane.php               # Plugin bootstrap
├── readme.txt                        # WordPress.org readme
├── includes/
│   └── class-paperpane.php     # Block + shortcode + shared renderer
├── block/
│   └── block.json                    # Block metadata
├── languages/
│   └── paperpane.pot           # Translation template
└── assets/
    ├── css/paperpane.css       # Front-end + editor styles
    └── js/block.js                   # Block editor (no build required)
```

## 💛 Support

If Paperpane saves you some time, a coffee is always appreciated.

<a href="https://ko-fi.com/gunjanjaswal"><img src="https://img.shields.io/badge/Buy%20me%20a%20coffee-Ko--fi-ff5e5b.svg?style=for-the-badge&logo=ko-fi&logoColor=white" alt="Ko-fi"></a>

## 👤 Author

**Gunjan Jaswal**

- 🌐 [gunjanjaswal.me](https://www.gunjanjaswal.me)
- ✉️ [hello@gunjanjaswal.me](mailto:hello@gunjanjaswal.me)
- 💻 [github.com/gunjanjaswal](https://github.com/gunjanjaswal)

## 📜 License

Released under the [GPL-2.0-or-later](LICENSE) license.
