#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <math.h>

//struct that contains the information needed from each line of the input
typedef struct{
    char date[1024];
    char cases[1024];
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

//gets a raw csv file and manipulates it to get the wanted information to proceed
//(the specific format of the csv is already excpected)
void csvToData( FILE* fp, Info info[1]) {

    //see how much line there is on the file in order to get, at the same reading, both dates needed
    int count = 0;
    char c;
    // Extract characters from file and store in character c 
    for (c = getc(fp); c != EOF; c = getc(fp)) {
        if (c == '\n'){ // Increment count if this character is newline 
            count = count + 1;
        } 
    }   

    //reading stream goes back to the beggining of the file
    rewind(fp);

    char buf[1024];
    int row_count = 0;
    int field_count = 0;


    /*goes to the final line - 6 and the final line itself,
     stores the date field and the cases toll field on the struct 'info' vector with size 2*/
    while (fgets(buf, 1024, fp)) {
        field_count = 0;
        row_count++;

        //first line doesnt have data, just defines what goes in each column
        if (row_count == 1) {
            continue;
        }

        char *field = strtok(buf, ",");
        while (field) {
            //we count the field to know if we are reading a date or a cases toll
            if (field_count == 0) {
                //first we check if it is a field of the 6 days earlier day
                if(row_count == (count - 6)){
                    strcpy(info[0].date, str_slice(field, 5, 10));
                //or from the latest day
                } else if (row_count == count){
                    strcpy(info[1].date, str_slice(field, 5, 10));
                }

            }

            if (field_count == 1) {
               if(row_count == (count - 6)){
                    strcpy(info[0].cases, field);
                } else if (row_count == count){
                    strcpy(info[1].cases, field);
                }              
            }


            field = strtok(NULL, ",");

            field_count++;   

        }
    }


    fclose(fp);

    return;

}

//calculating r0 based on this brasilian article calculus:
// https://hal.archives-ouvertes.fr/hal-02509142v2/file/epidemie_pt.pdf
double rCalculus(Info data[1]){
    
    double initial_cases = strtod(data[0].cases, NULL);
    double final_cases = strtod(data[1].cases, NULL);

    double r0 = final_cases / initial_cases;
    r0 = log(r0);
    r0 = r0 / 7;
    r0 = (1 + r0/0.25) * (r0 + 1);

    return r0;
}

int main(){
    
    Info data[1];

    FILE *fp = fopen("input.csv", "r");

    if (!fp) {
        printf("Can't open file\n");
        return 1;
    }

    csvToData(fp, data);

    double r0 = rCalculus(data);

    printf("\n\nO R0 de Sorocaba atualmente é:\n  --  %.2f  --\n\n", r0);
    
    return 0;
}