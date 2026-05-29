# OneUp Motion WordPress Project

OneUp Motion is a custom WordPress foundation for a creative agency and digital tools brand focused on design, websites, creative assets and useful online utilities.

This first version includes a custom theme for presentation and a separate plugin for future tools, so interactive utilities are not locked into the theme.

## Structure

```text
wp-content/
  themes/
    oneup-motion/
      assets/
      inc/
      template-parts/
      front-page.php
      page-tools.php
      style.css
  plugins/
    oneup-tools/
      includes/
      tools/
      assets/
      oneup-tools.php
```

## Theme Installation

1. Copy or keep `wp-content/themes/oneup-motion` inside your WordPress installation.
2. In WordPress admin, go to Appearance > Themes.
3. Activate **OneUp Motion**.
4. Optional: create and assign a Primary Menu with Home, Tools, Services, About and Contact links.
5. Set a static homepage if needed. The theme includes `front-page.php` for the custom homepage.

## Plugin Activation

1. Copy or keep `wp-content/plugins/oneup-tools` inside your WordPress installation.
2. In WordPress admin, go to Plugins.
3. Activate **OneUp Tools**.

## QR Generator Shortcode

Use this shortcode on any page:

```text
[oneup_qr_generator]
```

The first version renders a styled placeholder UI with URL, color controls, a logo upload placeholder, preview area and disabled download button. A real QR rendering library can be integrated later without moving the tool into the theme.

The theme also includes a **Tools** page template that automatically renders the QR generator.

## Roadmap

- Real QR rendering.
- Customizable QR styles.
- Logo in QR center.
- Border and frame options.
- SVG and PNG download.
- UTM builder.
- Image tools.
