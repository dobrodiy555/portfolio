# програмка принимает у юзера четыре цифры и выдает их задом наперед

list = []

for x in range(4):
    ele = input("Print any 4 symbols: ")
    list.append(ele)

i = 3
while i >= 0:
    print(list[i])
    i = i - 1
