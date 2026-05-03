from collections import deque
import svgwrite

class TreeNode:
    def __init__(self, value):
        self.value = value
        self.children = []
        self.sum_of_ancestors = 0
        self.x = 0  # Позиция для визуализации
        self.y = 0
        self.id = id(self)  # Уникальный идентификатор

def build_tree_interactively():
    """Интерактивное построение дерева"""
    print("\nПостроение дерева:")
    root_value = int(input("Введите значение корневого узла: "))
    root = TreeNode(root_value)
    queue = deque([root])
    
    while queue:
        current = queue.popleft()
        num_children = int(input(f"\nСколько детей у узла {current.value}? (0 для листа): "))
        
        for i in range(num_children):
            child_value = int(input(f"Введите значение {i+1}-го ребенка узла {current.value}: "))
            child = TreeNode(child_value)
            current.children.append(child)
            queue.append(child)
    
    return root

def calculate_ancestors_sum(node, current_sum=0):
    """Вычисляем сумму предков для каждого узла"""
    node.sum_of_ancestors = current_sum
    for child in node.children:
        calculate_ancestors_sum(child, current_sum + node.value)

def calculate_positions(root, start_x=500, start_y=100, level_height=120, node_spacing=100):
    """Вычисляем позиции для визуализации с балансировкой"""
    # BFS обход для расчета позиций
    queue = deque([(root, start_x, start_y)])
    positions = []
    
    while queue:
        node, x, y = queue.popleft()
        node.x, node.y = x, y
        positions.append((x, y))
        
        if node.children:
            # Центрируем детей относительно родителя
            total_width = (len(node.children) - 1) * node_spacing
            start_x = x - total_width // 2
            
            for i, child in enumerate(node.children):
                child_x = start_x + i * node_spacing
                child_y = y + level_height
                queue.append((child, child_x, child_y))

def create_svg_visualization(root, filename="tree.svg"):
    """Создаем красивую SVG визуализацию"""
    dwg = svgwrite.Drawing(filename, size=('100%', '100%'), profile='full')
    
    # Стили для элементов
    node_style = {
        'fill': '#4CAF50',
        'stroke': '#388E3C',
        'stroke-width': '2'
    }
    
    ancestor_style = {
        'fill': '#2196F3',
        'stroke': '#1565C0',
        'stroke-width': '1.5'
    }
    
    text_style = {
        'font-size': '14px',
        'font-weight': 'bold',
        'text-anchor': 'middle',
        'fill': 'white'
    }
    
    small_text_style = {
        'font-size': '12px',
        'text-anchor': 'middle',
        'fill': 'white'
    }
    
    # Сначала рисуем связи
    queue = deque([root])
    while queue:
        node = queue.popleft()
        for child in node.children:
            # Плавные кривые Безье для связей
            path = dwg.path(
                d=f"M {node.x} {node.y + 30} "
                f"C {node.x} {node.y + 70}, "
                f"{child.x} {child.y - 40}, "
                f"{child.x} {child.y - 20}",
                fill='none',
                stroke='#78909C',
                stroke_width=2
            )
            dwg.add(path)
            queue.append(child)
    
    # Затем рисуем узлы
    queue = deque([root])
    while queue:
        node = queue.popleft()
        
        # Основной узел
        dwg.add(dwg.circle(
            center=(node.x, node.y),
            r=30,
            **node_style
        ))
        
        # Значение узла
        dwg.add(dwg.text(
            str(node.value),
            insert=(node.x, node.y + 5),
            **text_style
        ))
        
        # Сумма предков
        dwg.add(dwg.circle(
            center=(node.x, node.y - 45),
            r=20,
            **ancestor_style
        ))
        
        dwg.add(dwg.text(
            str(node.sum_of_ancestors),
            insert=(node.x, node.y - 40),
            **small_text_style
        ))
        
        # Подпись суммы предков
        dwg.add(dwg.text(
            "Предки:",
            insert=(node.x, node.y - 60),
            font_size='10px',
            fill='#616161',
            text_anchor='middle'
        ))
        
        for child in node.children:
            queue.append(child)
    
    # Добавим легенду
    legend_x, legend_y = 50, 50
    dwg.add(dwg.rect(
        insert=(legend_x-10, legend_y-20),
        size=(200, 80),
        fill='white',
        stroke='#BDBDBD',
        rx=5,
        ry=5
    ))
    
    dwg.add(dwg.circle(
        center=(legend_x + 20, legend_y + 15),
        r=15,
        **node_style
    ))
    dwg.add(dwg.text(
        "Значение узла",
        insert=(legend_x + 60, legend_y + 20),
        font_size='12px',
        fill='#212121'
    ))
    
    dwg.add(dwg.circle(
        center=(legend_x + 20, legend_y + 45),
        r=12,
        **ancestor_style
    ))
    dwg.add(dwg.text(
        "Сумма предков",
        insert=(legend_x + 60, legend_y + 50),
        font_size='12px',
        fill='#212121'
    ))
    
    dwg.save()
    print(f"\nВизуализация сохранена в файл {filename}")

def print_tree_structure(node, level=0):
    """Выводим структуру дерева в консоль"""
    prefix = "    " * level
    print(f"{prefix}{node.value} (предки: {node.sum_of_ancestors})")
    for child in node.children:
        print_tree_structure(child, level + 1)

if __name__ == "__main__":
    print("Программа построения N-дерева с визуализацией")
    print("--------------------------------------------")
    
    # 1. Построение дерева
    tree_root = build_tree_interactively()
    
    # 2. Вычисление сумм предков
    calculate_ancestors_sum(tree_root)
    
    # 3. Вычисление позиций для визуализации
    calculate_positions(tree_root)
    
    # 4. Создание SVG визуализации
    create_svg_visualization(tree_root)
    
    # 5. Вывод структуры в консоль
    print("\nСтруктура дерева:")
    print_tree_structure(tree_root)