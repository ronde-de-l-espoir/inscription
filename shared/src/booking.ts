import { Schema } from "mongoose";
import { IEvent } from "./event";

interface ICommonPersonData {
    booking_id: string;
    member_id: string;
    name: string;
    surname: string;
    email: string;
    phone: string;
}

export interface IClientPerson extends ICommonPersonData {
    selectedEvent: IEvent;
    birth: string | Date;
    verifiedCategories: IEvent['price_categories'];
    bestPriceCategory: IEvent['price_categories'][0];
}

export interface IBuyer extends IClientPerson {
    fullName: string;
    children: IClientPerson[];
    pi_secret: string;
}

export interface IBooking extends ICommonPersonData {
    _id: string;
    attendants: number;
    event_id: Schema.Types.ObjectId;
    date: Date;
    payment: {
        hasPaid: boolean;
        date: Date;
        method: string;
        intentId: string;
        price: number;
    };
    vip: boolean;
}