from PIL import Image
import os

img_path = r'c:\Users\mohda\Local Sites\asocialchameleoncomu\app\public\wp-content\themes\asocial-chameleon\assets\images\hero-desktop.png'
save_path = r'c:\Users\mohda\Local Sites\asocialchameleoncomu\app\public\wp-content\themes\asocial-chameleon\assets\images\hero-desktop-cropped.png'

if os.path.exists(img_path):
    with Image.open(img_path) as img:
        width, height = img.size
        print(f"Original size: {width}x{height}")
        
        # Crop to a 3:1 aspect ratio or similar
        # We want more width, less height.
        # Let's keep the full width and reduce height to roughly 40% of width
        new_height = int(width * 0.4) 
        if new_height > height:
            new_height = height
            
        top = (height - new_height) // 2
        bottom = top + new_height
        
        img_cropped = img.crop((0, top, width, bottom))
        img_cropped.save(save_path)
        print(f"Cropped size: {width}x{new_height}")
        print(f"Saved to: {save_path}")
else:
    print("File not found.")
