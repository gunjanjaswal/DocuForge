=== Paperpane PDF Embed Viewer ===
Contributors: gunjanjaswal
Donate link: https://ko-fi.com/gunjanjaswal
Tags: pdf, embed, pdf viewer, document, shortcode
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Embed a PDF right inside a post or page with a clean, responsive, full-width viewer. Add it with a block or a shortcode. No third-party services.

== Description ==

Paperpane drops a PDF straight into your content so readers can scroll through it without leaving the page. Pick a file from your Media Library (or paste a URL), choose a height, and you are done.

It uses the browser's own PDF viewer, so there is no heavy library to load and nothing is sent to an outside service. Your files stay on your own site.

**What you get**

* A "Paperpane" block for the editor, with a live preview while you set it up.
* A `[pp-pdf-embed]` shortcode for the classic editor, widgets, or anywhere shortcodes run.
* Control over the viewer height and the built-in toolbar.
* Fits the page to the viewer width and hides the thumbnail sidebar for a clean, full-width read.
* Responsive by default, so it fits phones as well as wide desktop layouts.
* Translation ready, properly escaped output, and no settings page to wade through.

== Installation ==

**From your dashboard**

1. Go to **Plugins → Add New → Upload Plugin**.
2. Choose `paperpane.zip` and click **Install Now**.
3. Click **Activate**.

**Manually over FTP/SFTP**

1. Unzip the download and upload the `paperpane` folder to `/wp-content/plugins/`.
2. Go to **Plugins** in WordPress and activate **Paperpane**.

There is no settings page. Once it is active you can add PDFs straight away.

== How to use ==

**Embed a PDF with the block**

1. Edit a post or page.
2. Click the **+** (block inserter) and search for **Paperpane**.
3. Add the block, then click **Upload** or **Media Library** and pick your PDF.
4. In the block sidebar, set the **viewer height**, show or hide the **toolbar**, and type an **accessible title** if you like.
5. Use the toolbar's **Replace PDF** button any time you want to swap the file.
6. Publish. The PDF shows up inline, fitted to the width of your content.

Tip: to run the viewer edge to edge, select the block and choose **Wide width** or **Full width** from the block toolbar.

**Embed a PDF with the shortcode**

Use the shortcode when you are in the classic editor, a widget, or a template file.

Embed a file from your Media Library by its attachment ID:

`[pp-pdf-embed id="123"]`

Embed any PDF by its URL, taller and with the toolbar hidden:

`[pp-pdf-embed url="https://example.com/files/report.pdf" height="800" toolbar="0"]`

Call it from a template with `do_shortcode()`:

`<?php echo do_shortcode( '[pp-pdf-embed id="123"]' ); ?>`

**Finding a PDF's attachment ID**

Open **Media → Library**, click the PDF, and read the `item=` number in the URL, or copy the file URL and use it with the `url` attribute instead.

**Shortcode attributes**

* `id` — Media Library attachment ID of the PDF.
* `url` — Direct URL to a PDF (used if no `id` is given).
* `height` — Viewer height in pixels. Default `600`.
* `toolbar` — `1` to show the viewer toolbar, `0` to hide it. Default `1`.
* `title` — Accessible title for the viewer (read by screen readers).

The `[paperpane]`, `[docuforge]`, `[pdf-embed-forge]` and `[pdf-forge]` shortcodes also work as aliases, so anything you built before keeps running.

== Frequently Asked Questions ==

= Does it work on mobile? =

Yes. On phones, where inline PDF frames are cramped (and unreliable in iOS Safari), the embed shows the PDF's first page with a "View full screen" button that opens it in the device's full-screen viewer. The first-page image is the one WordPress generates on upload; if your host can't make it, a document icon is shown instead. The inline viewer is used on larger screens.

= Can I hide the toolbar or the pages sidebar? =

The thumbnail sidebar is hidden automatically for a clean read. To hide the toolbar as well, set `toolbar="0"` on the shortcode or flip the toggle in the block sidebar. These are honoured by Chromium-based browsers; others simply show their own controls.

= Can I embed a PDF hosted on another site? =

Yes, pass its full URL to the `url` attribute. Note that some hosts block being shown inside a frame, which is their setting rather than something the plugin controls.

= Does it send my PDFs anywhere? =

No. The browser loads the file straight from your site. Nothing is uploaded to or proxied through any external service.

= Is there a settings page? =

No. Everything is configured per embed, on the block or the shortcode.

== Screenshots ==

1. A PDF embedded inline in a post, fitted to the content width.
2. The block sidebar with height, toolbar, and accessible-title controls.

== Changelog ==

= 1.2.0 =
* Renamed the plugin to Paperpane, with the `[pp-pdf-embed]` shortcode and the Paperpane PDF Embed block. The `[paperpane]`, `[docuforge]`, `[pdf-embed-forge]` and `[pdf-forge]` shortcodes and the older blocks also work, so existing embeds are unaffected.

= 1.1.0 =
* Renamed the plugin to DocuForge, with the `[docuforge]` shortcode and a DocuForge PDF block. The former `[pdf-embed-forge]` and `[pdf-forge]` shortcodes and the old block keep working.

= 1.0.5 =
* Keep the mobile "View full screen" button on a single line.

= 1.0.4 =
* Mobile card now shows the PDF's first page (from the preview WordPress generates on upload) with a "View in Full Screen" button, falling back to a document icon when no preview exists.

= 1.0.3 =
* Mobile: phones now show a tap-to-open card that opens the PDF full screen, instead of a cramped inline frame. Desktop keeps the inline viewer.

= 1.0.2 =
* Renamed the plugin to PDF Embed Forge, with the `[pdf-embed-forge]` shortcode (the old `[pdf-forge]` shortcode still works).
* Wide and Full width block alignment now break the viewer out of the content column.
* Expanded the how-to documentation.
* Added a `languages` folder with a translation template.

= 1.0.1 =
* The viewer now fits the page to its width and hides the thumbnail sidebar for a clean, full-width read.
* Added Ko-fi and contact links to the plugin row on the Plugins screen.
* Removed the separate download link; the viewer's own toolbar already offers downloads.

= 1.0.0 =
* Initial release: block and shortcode with height and toolbar controls.

== Upgrade Notice ==

= 1.2.0 =
Renamed to Paperpane. Your existing embeds keep working.

= 1.1.0 =
Renamed to DocuForge. Your existing embeds keep working.

= 1.0.5 =
Tidier mobile button.

= 1.0.4 =
Mobile now shows a first-page preview with a View full screen button.

= 1.0.3 =
Better mobile experience: a tap-to-open card on phones.

= 1.0.2 =
Renamed to Paperpane. Your existing embeds keep working.

= 1.0.1 =
Cleaner full-width viewer with the thumbnail sidebar hidden.

= 1.0.0 =
First release.
