"""
convert_pdf_to_webp.py — Konversi PDF ke gambar WebP per halaman.

Usage:
  python convert_pdf_to_webp.py --pdf path/to/file.pdf --out path/to/output/pages/ [--dpi 150]

Output:
  pages/N.webp        — Halaman normal (flipbook view)
  pages/N-large.webp  — Halaman zoom-in (high DPI)
  pages/N-thumb.webp  — Thumbnail panel bawah

Return code: 0 = sukses, 1 = error
Stdout (last line): jumlah halaman (integer) jika sukses
"""

import argparse
import sys
import os
from pathlib import Path

def convert_pdf(pdf_path: str, out_dir: str, dpi: int = 150):
    try:
        import fitz  # PyMuPDF
    except ImportError:
        print("ERROR: PyMuPDF tidak terinstall. Jalankan: python -m pip install pymupdf", file=sys.stderr)
        sys.exit(1)

    try:
        from PIL import Image
    except ImportError:
        print("ERROR: Pillow tidak terinstall. Jalankan: python -m pip install pillow", file=sys.stderr)
        sys.exit(1)

    pdf_path = Path(pdf_path)
    out_dir  = Path(out_dir)

    if not pdf_path.exists():
        print(f"ERROR: File PDF tidak ditemukan: {pdf_path}", file=sys.stderr)
        sys.exit(1)

    out_dir.mkdir(parents=True, exist_ok=True)

    try:
        doc = fitz.open(str(pdf_path))
    except Exception as e:
        print(f"ERROR: Tidak bisa membuka PDF: {e}", file=sys.stderr)
        sys.exit(1)

    num_pages = doc.page_count
    print(f"[PDF] {pdf_path.name} — {num_pages} halaman", file=sys.stderr)

    # DPI settings
    dpi_normal = dpi          # Normal view
    dpi_large  = dpi * 2      # Zoom-in (2x)
    dpi_thumb  = max(40, dpi // 3)  # Thumbnail (kecil)

    mat_normal = fitz.Matrix(dpi_normal / 72, dpi_normal / 72)
    mat_large  = fitz.Matrix(dpi_large  / 72, dpi_large  / 72)
    mat_thumb  = fitz.Matrix(dpi_thumb  / 72, dpi_thumb  / 72)

    for page_num in range(num_pages):
        page_idx = page_num + 1  # 1-indexed
        page = doc[page_num]

        print(f"  [Page {page_idx}/{num_pages}]", file=sys.stderr)

        # --- Normal ---
        pix = page.get_pixmap(matrix=mat_normal, alpha=False)
        img = _pixmap_to_pil(pix)
        img.save(out_dir / f"{page_idx}.webp", "WEBP", quality=82, method=6)

        # --- Large (zoom) ---
        pix_large = page.get_pixmap(matrix=mat_large, alpha=False)
        img_large = _pixmap_to_pil(pix_large)
        img_large.save(out_dir / f"{page_idx}-large.webp", "WEBP", quality=85, method=6)

        # --- Thumb ---
        pix_thumb = page.get_pixmap(matrix=mat_thumb, alpha=False)
        img_thumb = _pixmap_to_pil(pix_thumb)
        img_thumb.save(out_dir / f"{page_idx}-thumb.webp", "WEBP", quality=72, method=6)

    doc.close()

    # Print jumlah halaman ke stdout (dibaca oleh PHP)
    print(num_pages)
    return num_pages


def _pixmap_to_pil(pix):
    """Konversi fitz.Pixmap ke PIL.Image."""
    from PIL import Image
    if pix.n == 4:  # RGBA
        mode = "RGBA"
    else:
        mode = "RGB"
    return Image.frombytes(mode, (pix.width, pix.height), pix.samples)


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Konversi PDF ke WebP per halaman")
    parser.add_argument("--pdf", required=True, help="Path ke file PDF")
    parser.add_argument("--out", required=True, help="Folder output untuk halaman WebP")
    parser.add_argument("--dpi", type=int, default=150, help="DPI render (default: 150)")
    args = parser.parse_args()

    convert_pdf(args.pdf, args.out, args.dpi)
