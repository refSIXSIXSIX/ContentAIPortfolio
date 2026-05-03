import random
from collections import deque
import time
import pickle

def create_tree_data(node_count):
    start_time = time.time()
    
    if node_count == 0:
        return [], []

    node_values = [random.randint(1, 100) for _ in range(node_count)]
    connections = [[] for _ in range(node_count)]

    node_queue = deque()
    if node_count > 0:
        node_queue.append(0)
        next_node = 1
        
        while next_node < node_count and node_queue:
            parent = node_queue.popleft()

            if next_node < node_count:
                connections[parent].append(next_node)
                node_queue.append(next_node)
                next_node += 1

            if next_node < node_count:
                connections[parent].append(next_node)
                node_queue.append(next_node)
                next_node += 1

    print(f"\nВремя генерации: {time.time() - start_time:.2f} сек")
    return connections, node_values

def save_data(connections, node_values, 
              connections_file='adj_matrix.pkl', 
              values_file='node_values.pkl'):
    start_time = time.time()

    with open(connections_file, 'wb') as f:
        pickle.dump(connections, f)

    with open(values_file, 'wb') as f:
        pickle.dump(node_values, f)

    print(f"Время сохранения: {time.time() - start_time:.2f} сек")

if __name__ == "__main__":
    try:
        count = int(input("Введите количество вершин: "))
        if count < 1:
            print("Число должно быть положительным")
            exit()

        print(f"\nГенерация дерева с {count} вершинами...")
        adj_data, values_data = create_tree_data(count)

        print("\nСохранение данных...")
        save_data(adj_data, values_data)

        print(f"\nДерево сохранено в 'adj_matrix.pkl' и 'node_values.pkl'")
    except MemoryError:
        print("Ошибка: недостаточно памяти")
    except ValueError:
        print("Ошибка: введите целое число")