# Typecho-TransitTheme
A theme for Typecho focused on effective navigation and simple graphics. Inspired by various sources of wayfinding navigation systems.
Supports MySQL / SQLite in backend.

# Info
- `themes/Transit`: The theme
- `plugins/CatColor`: Category-coloring plugin (optional)
## About font:
`Transit.css` uses `Source Han Sans SC` cropped to L1&2 GB2312 as a final fallback. To generate the font, follow these instructions:
1. `pip install fonttools brotli` to install required packages.
2. `pyftsubset SourceHanSansSC-VF.otf.woff2 --output-file=SourceHanSansSC-VF-GB2312subset.woff2 --text-file=<subset-file> --flavor=woff2 --no-hinting` to generate the font, where `<subset-file>` contains the characters to include.
3. Place the generated font file under `themes/Transit/`.
