import pickle
from scipy.sparse import csr_matrix, coo_matrix
import svgwrite
import os
import webbrowser
import time
import psutil

def load_matrix(path='matrix.pkl'):
    """Загружает матрицу из файла"""
    with open(path, 'rb') as f:
        return pickle.load(f)

def create_matrix_svg_blocks(matrix, title="Matrix Blocks", filename="matrix_blocks.svg"):
    """Создает SVG с выделенными блоками матрицы (9 блоков)"""
    size = matrix.shape[0]
    cell_size = 25
    padding = 10
    font_size = 10
    block_size = 5
    vertical_padding = 30  # Увеличенное расстояние между строками
    
    svg_width = 3 * (block_size * cell_size + 2*padding)
    svg_height = (3 * block_size * cell_size) + (2 * vertical_padding) + 100
    
    dwg = svgwrite.Drawing(filename, size=(svg_width, svg_height))
    
    # Заголовок
    dwg.add(dwg.text(title, insert=(svg_width//2, 30), 
                    font_size=font_size+4, font_weight="bold",
                    text_anchor="middle", fill="#333"))
    
    # Цвета для блоков
    block_colors = [
        "#F8D7DA", "#D1ECF1", "#D4EDDA",  # Верхний ряд
        "#FFF3CD", "#E2E3E5", "#FCE3AE",  # Средний ряд
        "#D6C8E4", "#B8D8EB", "#C9E4CA"   # Нижний ряд
    ]

    def draw_block(r_start, c_start, x_offset, y_offset, label, color):
        # Фон блока
        dwg.add(dwg.rect(
            insert=(x_offset-padding//2, y_offset-padding//2),
            size=(block_size*cell_size+padding, block_size*cell_size+padding),
            fill=color,
            opacity=0.3,
            rx=5, ry=5
        ))
        
        # Заголовок блока
        dwg.add(dwg.text(label, 
                        insert=(x_offset + block_size*cell_size//2, y_offset-10),
                        font_size=font_size+1,
                        font_weight="bold",
                        text_anchor="middle",
                        fill="#333"))
        
        # Ячейки матрицы
        for i in range(block_size):
            for j in range(block_size):
                row = min(r_start + i, size - 1)
                col = min(c_start + j, size - 1)
                value = matrix[row, col]
                
                cell_color = "#FCE3AE" if value != 0 else "#E9B451"
                
                dwg.add(dwg.rect(
                    insert=(x_offset + j*cell_size, y_offset + i*cell_size),
                    size=(cell_size-1, cell_size-1),
                    fill=cell_color,
                    stroke="#888",
                    rx=2, ry=2
                ))
                
                if value != 0:
                    dwg.add(dwg.text(
                        str(value),
                        insert=(x_offset + j*cell_size + cell_size//2,
                               y_offset + i*cell_size + cell_size//2),
                        font_size=font_size,
                        text_anchor="middle",
                        dominant_baseline="middle"
                    ))

    # Позиции 9 блоков с увеличенными вертикальными отступами
    blocks = [
        # Верхний ряд
        (0, 0, padding, 50, "Top Left", block_colors[0]),
        (0, size//2 - block_size//2, block_size*cell_size + 2*padding, 50, "Top Center", block_colors[1]),
        (0, size-block_size, 2*(block_size*cell_size + padding) + padding, 50, "Top Right", block_colors[2]),
        
        # Средний ряд
        (size//2 - block_size//2, 0, padding, 50 + block_size*cell_size + vertical_padding, "Middle Left", block_colors[3]),
        (size//2 - block_size//2, size//2 - block_size//2, block_size*cell_size + 2*padding, 50 + block_size*cell_size + vertical_padding, "Center", block_colors[4]),
        (size//2 - block_size//2, size-block_size, 2*(block_size*cell_size + padding) + padding, 50 + block_size*cell_size + vertical_padding, "Middle Right", block_colors[5]),
        
        # Нижний ряд
        (size-block_size, 0, padding, 50 + 2*(block_size*cell_size + vertical_padding), "Bottom Left", block_colors[6]),
        (size-block_size, size//2 - block_size//2, block_size*cell_size + 2*padding, 50 + 2*(block_size*cell_size + vertical_padding), "Bottom Center", block_colors[7]),
        (size-block_size, size-block_size, 2*(block_size*cell_size + padding) + padding, 50 + 2*(block_size*cell_size + vertical_padding), "Bottom Right", block_colors[8])
    ]

    for r_start, c_start, x, y, label, color in blocks:
        draw_block(r_start, c_start, x, y, label, color)

    dwg.save()
    abs_path = os.path.abspath(filename)
    webbrowser.open(f"file://{abs_path}")
    print(f"SVG файл сохранен: {abs_path}")

def rotate_right(matrix):
    """Поворот на 90° вправо"""
    coo = matrix.tocoo()
    n = matrix.shape[0]
    new_row = coo.col
    new_col = n - 1 - coo.row
    return csr_matrix((coo.data, (new_row, new_col)), shape=(n, n), dtype=matrix.dtype)

def rotate_left(matrix):
    """Поворот на 90° влево"""
    coo = matrix.tocoo()
    n = matrix.shape[0]
    new_row = n - 1 - coo.col
    new_col = coo.row
    return csr_matrix((coo.data, (new_row, new_col)), shape=(n, n), dtype=matrix.dtype)

def main():
    try:
        matrix = load_matrix()
        print("Матрица успешно загружена.")
    except Exception as e:
        print(f"Ошибка: {e}")
        return

    while True:
        print("\n1. Показать ключевые блоки матрицы")
        print("2. Повернуть на 90° вправо")
        print("3. Повернуть на 90° влево")
        print("4. Выход")
        
        choice = input("Выберите действие: ").strip()
        
        if choice == "1":
            create_matrix_svg_blocks(matrix)
        elif choice == "2":
            matrix = rotate_right(matrix)
            print("Матрица повернута на 90° вправо.")
        elif choice == "3":
            matrix = rotate_left(matrix)
            print("Матрица повернута на 90° влево.")
        elif choice == "4":
            break

if __name__ == '__main__':
    main()