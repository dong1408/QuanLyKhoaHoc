import {Injectable} from "@angular/core";
import {BehaviorSubject, Subject} from "rxjs";

@Injectable()
export class PagingService{
    pageIndex$ = new BehaviorSubject<number>(1)
    keyword$ = new BehaviorSubject<string>("")
    sortBy$ = new BehaviorSubject<string>("created_at")
    isLock$ = new BehaviorSubject<number>(0)
    filter$ = new BehaviorSubject<string>('all')
    resetValues(): void {
        this.pageIndex$.next(1);
        this.keyword$.next("");
        this.sortBy$.next("created_at");
        this.isLock$.next(0);
        this.filter$.next('all')
    }

    updatePageIndex(newIndex: number) {
        this.pageIndex$.next(newIndex)
    }

    updateKeyword(newKeyword: string) {
        this.keyword$.next(newKeyword)
    }

    updateSortBy(newSortBy: string) {
        this.sortBy$.next(newSortBy)
    }

    updateIsLock(newIsLock: number){
        this.isLock$.next(newIsLock)
    }

    updateFilter(newFilter: string){
        this.filter$.next(newFilter)
    }

    onDestroy() {
        this.pageIndex$.next(0)
        this.keyword$.next("")
        this.sortBy$.next("created_at")
        this.isLock$.next(0)
        this.filter$.next('all')
    }
}