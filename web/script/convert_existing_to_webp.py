"""
Script konversi PNG -> WebP untuk folder magazine_january_2025/pages/
Jalankan: python convert_existing_to_webp.py
"""
import os
import sys
from pathlib import Path
from PIL import Image

def convert_png_to_webp(pages_dir: Path, quality_normal=82, quality_large=85, quality_thumb=75):
    pages_dir = Path(pages_dir)
    if not pages_dir.exists():
        print(f"[ERROR] Folder tidak ditemukan: {pages_dir}")
        sys.exit(1)

    png_files = list(pages_dir.glob("*.png"))
    if not png_files:
        print("[INFO] Tidak ada file PNG ditemukan.")
        return

    converted = 0
    failed = 0
    total_saved_bytes = 0

    for png_path in sorted(png_files):
        webp_path = png_path.with_suffix(".webp")

        # Tentukan quality berdasarkan suffix nama file
        name = png_path.stem  # e.g. "1", "1-large", "1-thumb"
        if name.endswith("-large"):
            quality = quality_large
        elif name.endswith("-thumb"):
            quality = quality_thumb
        else:
            quality = quality_normal

        try:
            original_size = png_path.stat().st_size
            img = Image.open(png_path)

            # Pastikan mode RGBA didukung WebP
            if img.mode in ("P", "LA"):
                img = img.convert("RGBA")
            elif img.mode not in ("RGB", "RGBA"):
                img = img.convert("RGB")

            img.save(webp_path, "WEBP", quality=quality, method=6)
            webp_size = webp_path.stat().st_size
            saved = original_size - webp_size
            total_saved_bytes += saved

            print(f"  [OK] {png_path.name} -> {webp_path.name}  "
                  f"({original_size//1024}KB -> {webp_size//1024}KB, hemat {saved//1024}KB)")

            # Hapus PNG asli
            png_path.unlink()
            converted += 1

        except Exception as e:
            print(f"  [FAIL] {png_path.name}: {e}")
            failed += 1

    print(f"\n=== Selesai ===")
    print(f"  Berhasil : {converted}")
    print(f"  Gagal    : {failed}")
    print(f"  Total hemat: {total_saved_bytes // (1024*1024):.1f} MB")


if __name__ == "__main__":
    # Jalankan dari root project atau langsung dari folder web/
    script_dir = Path(__file__).parent
    pages_dir = script_dir / "web" / "magazine_january_2025" / "pages"

    if not pages_dir.exists():
        # Coba dari folder web jika script dijalankan dari sana
        pages_dir = script_dir / "magazine_january_2025" / "pages"

    print(f"Konversi PNG -> WebP di: {pages_dir}")
    convert_png_to_webp(pages_dir)
