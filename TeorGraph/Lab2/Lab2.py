from collections import deque
import sys
import time

class TreeNode:
    __slots__ = ['value', 'children', 'sum_of_ancestors', 'id']
    
    def __init__(self, value):
        self.value = value
        self.children = []
        self.sum_of_ancestors = 0
        self.id = id(self)

def build_linear_tree(nodes_count=1_000_000):
    """Построение линейного дерева (одной ветви)"""
    print(f"\nПостроение линейного дерева с {nodes_count:,} узлами...")
    start_time = time.time()
    
    root = TreeNode(1)
    current = root
    
    for i in range(2, nodes_count + 1):
        child = TreeNode(i)
        current.children.append(child)
        current = child
    
    print(f"Линейное дерево построено за {time.time() - start_time:.2f} секунд")
    return root

def calculate_ancestors_sum(root):
    """Итеративное вычисление суммы предков (без рекурсии)"""
    print("\nВычисление сумм предков...")
    start_time = time.time()
    
    stack = [(root, 0)]
    
    while stack:
        node, current_sum = stack.pop()
        node.sum_of_ancestors = current_sum
        for child in reversed(node.children):
            stack.append((child, current_sum + node.value))
    
    print(f"Суммы вычислены за {time.time() - start_time:.2f} секунд")

def draw_console_tree(root, max_nodes=100):
    """Отрисовка первых max_nodes узлов дерева в консоли"""
    print("\n" + "="*50)
    print(f"ВИЗУАЛИЗАЦИЯ ПЕРВЫХ {max_nodes} УЗЛОВ ДЕРЕВА:")
    print("="*50 + "\n")
    
    current = root
    for i in range(max_nodes):
        if not current:
            break
            
        # Рисуем узел
        if i == 0:
            print(f"└── {current.value} (Σ:{current.sum_of_ancestors})")
        else:
            print("    " * i + f"└── {current.value} (Σ:{current.sum_of_ancestors})")
        
        if current.children:
            current = current.children[0]
        else:
            break
    
    print("\n" + "="*50 + "\n")

def print_nodes_info(root, first_nodes=1000, last_nodes=5):
    """Вывод информации о первых и последних узлах"""
    # Подсчет общего количества узлов
    node_count = 1
    current = root
    while current.children:
        current = current.children[0]
        node_count += 1
    
    print(f"\nВсего узлов: {node_count:,}")
    print(f"Значение корня: {root.value} (Σ предков: {root.sum_of_ancestors})")
    
    # Вывод первых first_nodes узлов (только суммы)
    print(f"\nПервые {first_nodes} узлов (суммы предков):")
    current = root
    for i in range(first_nodes):
        if not current:
            break
        if i < 10 or i % 100 == 99 or i == first_nodes - 1:
            print(f"[{i+1:>4}] Σ предков: {current.sum_of_ancestors}")
        current = current.children[0] if current.children else None
    
    # Вывод последних last_nodes узлов
    print(f"\nПоследние {last_nodes} узлов:")
    nodes = []
    current = root
    while current:
        nodes.append(current)
        if len(nodes) > last_nodes:
            nodes.pop(0)
        current = current.children[0] if current.children else None
    
    for i, node in enumerate(nodes, start=node_count-last_nodes+1):
        print(f"[{i:>6,}] Значение: {node.value:<6} | Σ предков: {node.sum_of_ancestors}")

if __name__ == "__main__":
    sys.setrecursionlimit(10000)
    
    print("\n" + "="*50)
    print("ПРОГРАММА ДЛЯ АНАЛИЗА ЛИНЕЙНОГО ДЕРЕВА")
    print("="*50 + "\n")
    
    # Настройки
    NODES_COUNT = 1_000_000
    DRAW_NODES = 50      
    PRINT_NODES = 1000    
    LAST_NODES = 5         
    
    # Строим дерево
    tree_root = build_linear_tree(NODES_COUNT)
    calculate_ancestors_sum(tree_root)
    
    # Визуализация и вывод информации
    draw_console_tree(tree_root, DRAW_NODES)
    print_nodes_info(tree_root, PRINT_NODES, LAST_NODES)
    
    print("\n" + "="*50)
    print("АНАЛИЗ ДЕРЕВА ЗАВЕРШЕН")
    print("="*50 + "\n")