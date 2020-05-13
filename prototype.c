#include <stdio.h>
#include <string.h>
#include <stdlib.h>

    typedef struct{
        char date[1024];
        char death[1024];
    } Info;

/**
 * Extracts a selection of string and return a new string or NULL.
 * It supports both negative and positive indexes.
 */
char *
str_slice(char str[], int slice_from, int slice_to)
{
    // if a string is empty, returns nothing
    if (str[0] == '\0')
        return NULL;

    char *buffer;
    size_t str_len, buffer_len;

    // for negative indexes "slice_from" must be less "slice_to"
    if (slice_to < 0 && slice_from < slice_to) {
        str_len = strlen(str);

        // if "slice_to" goes beyond permissible limits
        if (abs(slice_to) > str_len - 1)
            return NULL;

        // if "slice_from" goes beyond permissible limits
        if (abs(slice_from) > str_len)
            slice_from = (-1) * str_len;

        buffer_len = slice_to - slice_from;
        str += (str_len + slice_from);

    // for positive indexes "slice_from" must be more "slice_to"
    } else if (slice_from >= 0 && slice_to > slice_from) {
        str_len = strlen(str);

        // if "slice_from" goes beyond permissible limits
        if (slice_from > str_len - 1)
            return NULL;

        buffer_len = slice_to - slice_from;
        str += slice_from;

    // otherwise, returns NULL
    } else
        return NULL;

    buffer = calloc(buffer_len, sizeof(char));
    strncpy(buffer, str, buffer_len);
    return buffer;
}


void csvToData(Info info[1]) {

    FILE *fp = fopen("input.csv", "r");

    if (!fp) {
        printf("Can't open file\n");
        return;
    }


    //ver quantas linhas tem no arquivo para poder, na mesma leitura, pegar o ultimo valor de mortes e de 7 dias anteriores
    int count = 0;
    char c;
    // Extract characters from file and store in character c 
    for (c = getc(fp); c != EOF; c = getc(fp)) {
        if (c == '\n'){ // Increment count if this character is newline 
            count = count + 1;
        } 
    }   

    //voltar a stream de leitura para o inicio do arquivo
    rewind(fp);

    char buf[1024];
    int row_count = 0;
    int field_count = 0;


    //le ate o final do arquivo para pegar o ultimo valor
    while (fgets(buf, 1024, fp)) {
        field_count = 0;
        row_count++;

        //primeira linha apenas define os campos, nao ha valor de fato
        if (row_count == 1) {
            continue;
        }

        char *field = strtok(buf, ",");
        while (field) {
            if (field_count == 0) {
                if(row_count == (count - 6)){
                    strcpy(info[0].date, str_slice(field, 5, 10));
                } else if (row_count == count){
                    strcpy(info[1].date, str_slice(field, 5, 10));
                }

            }
            if (field_count == 1) {
               if(row_count == (count - 6)){
                    strcpy(info[0].death, field);
                } else if (row_count == count){
                    strcpy(info[1].death, field);
                }              
            }


            field = strtok(NULL, ",");

            field_count++;   

        }
    }


    fclose(fp);

    return;

}

int main(){
    
    Info data[1];
    csvToData(data);

    printf("%s\n", data[0].death); //testando função
    
    return 0;
}