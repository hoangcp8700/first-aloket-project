<?php use App\Contact; ?>
@foreach($contacts as $contact)
    @if($contact['status'] == 0)
    <tr class="unread" onClick="showMessage({{$contact['id']}})">
        <td class="inbox-small-cells"><input type="checkbox" class="mail-checkbox"></td>
        <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
        <td class="view-message  dont-show"><a href="javascript:void(0)"> {{$contact['name']}} </a></td>
        <td class="subject" ><a href="javascript:void(0)"> {{$contact['subject']}} </a></td>
        <td class="view-message  text-right"> {{Contact::date($contact['created_at'])}} </td>
    </tr>
    @else
    <tr class="bg-white" onClick="showMessage({{$contact['id']}})" >
        <td class="inbox-small-cells"><input type="checkbox" class="mail-checkbox"></td>
        <td class="inbox-small-cells"><i class="fa fa-star inbox-started " ></i></td>
        <td class="view-message  dont-show"><a href="javascript:void(0)"> {{$contact['name']}} </a></td>
        <td class="subject" ><a href="javascript:void(0)"> {{$contact['subject']}} </a></td>
        <td class="view-message  text-right"> {{Contact::date($contact['created_at'])}} </td>
      </tr>
    @endif
@endforeach
