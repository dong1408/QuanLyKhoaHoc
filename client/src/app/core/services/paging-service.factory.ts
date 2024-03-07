import {Injectable} from "@angular/core";
import {PagingService} from "./paging.service";

@Injectable()
export class PagingServiceFactory{
    constructor() {
    }

    createPagingServiceInstance():PagingService{
        return new PagingService();
    }
}