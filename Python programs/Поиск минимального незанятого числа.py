##програмка которая находит минимальное значение из списка чисел, которое не занято (т.е. после которого не идет большее на единицу число)

list1 = [1, 2, 3, 4, 5, 6, 7, 8, 10, 11]
i = 0
while i < len(list1):
    i += 1
    if list1[i] - i != 1:
        print(i + 1, "is a minimum free number")
        break

    