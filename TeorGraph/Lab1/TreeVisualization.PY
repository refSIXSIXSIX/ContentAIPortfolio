from collections import deque
import time
from graphviz import Digraph
import webbrowser
import os
import random
import pickle

def load_pickle(filename):
    with open(filename, 'rb') as f:
        data = pickle.load(f)
    return data

def create_adjacency_list(adj_matrix):
    graph = {i + 1: [] for i in range(len(adj_matrix))}
    
    for i, neighbors in enumerate(adj_matrix):
        for neighbor in neighbors:
            graph[i + 1].append(neighbor + 1)
    return graph

def count_nodes_by_level(graph, start_node=1):
    timer = time.time()
    
    if start_node not in graph:
        print("Корневой узел не существует")
        return

    current_nodes = [(start_node, 0)]
    levels = {}
    visited_nodes = set()

    while current_nodes:
        next_nodes = []

        for node, level in current_nodes:
            if node not in visited_nodes:
                visited_nodes.add(node)

                if level not in levels:
                    levels[level] = 0
                levels[level] += 1

                for child in graph.get(node, []):
                    if child not in visited_nodes:
                        next_nodes.append((child, level + 1))

        current_nodes = next_nodes

    print("\nКоличество вершин по уровням:")
    total = 0
    for level in sorted(levels.keys()):
        print(f"Уровень {level}: {levels[level]} вершины(а)")
        total += levels[level]

    print(f"\nВремя выполнения функции: {time.time() - timer:.6f} секунд")
    print(f"Всего узлов: {total}")

def get_random_pastel_color():
    r = random.randint(200, 255)
    g = random.randint(200, 255)
    b = random.randint(200, 255)
    return f"#{r:02x}{g:02x}{b:02x}"

def display_tree(graph, node_values, start_node=1):
    tree = Digraph(format='svg')
    tree.attr(rankdir='TB')
    visited = set()
    node_colors = {}

    def traverse(node, color):
        visited.add(node)
        node_colors[node] = color
        label = f"{node} ({node_values[node - 1]})"
        tree.node(str(node), label, style='filled', fillcolor=color)

        children = [child for child in graph[node] if child not in visited]

        if children:
            new_color = get_random_pastel_color()
            for child in children:
                traverse(child, new_color)
                tree.edge(str(node), str(child), dir='none')

    root_color = get_random_pastel_color()
    traverse(start_node, root_color)

    output_path = tree.render("tree_visualization")
    print(f"SVG-файл сохранён как {output_path}")

    abs_path = os.path.abspath(output_path)
    webbrowser.open(f"file://{abs_path}")

def print_tree_structure(graph, values, root=1):
    visited_nodes = set()

    """def print_node(node, prefix="", is_last=True):
        visited_nodes.add(node)
        branch = "└── " if is_last else "├── "
        value = values[node - 1]
        print(prefix + branch + f"{node} ({value})")

        children = [n for n in graph[node] if n not in visited_nodes]

        for i, child in enumerate(children):
            last_child = (i == len(children) - 1)
            new_prefix = prefix + ("    " if is_last else "│   ")
            print_node(child, new_prefix, last_child)

    print_node(root)"""

adj_matrix_file = "adj_matrix.pkl"
node_values_file = "node_values.pkl"

try:
    adj_matrix = load_pickle(adj_matrix_file)
    values = load_pickle(node_values_file)

    graph = create_adjacency_list(adj_matrix)

    print("Структура дерева:")

    choice = input("Введите 1, если хотите отрисовать дерево в терминале (любое другое значение — пропустить): ")
    if choice == "1":
        print_tree_structure(graph, values)

    count_nodes_by_level(graph)

    choice = input("Введите 2, если хотите отрисовать дерево в svg (любое другое значение — пропустить): ")
    if choice == "2":
        print("\nВизуализация дерева....")
        display_tree(graph, values)

except FileNotFoundError:
    print("Ошибка: файлы не найдены. Убедитесь, что файлы 'adj_matrix.pkl' и 'node_values.pkl' существуют.")