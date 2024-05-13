@if (isset($permissions) && count($permissions))
    @foreach($permissions as $permissionAlias => $permission)

        @if (is_array($permission))
            <section>
                <p>{{$permissionAlias}}</p>
                @foreach($permission as $permissionSlug => $permissionTitle )
                    @if (is_array($permissionTitle))
                        <section style="padding-left: 10px">
                            <p>{{$permissionSlug}}</p>
                            @foreach($permissionTitle as $permissionSlug2 => $permissionTitle2)
                                <p><label class="checkbox">
                                        <input type="checkbox" value="1" name="permissions[{{$permissionSlug2}}]"
                                               @if (isset($groupPermissionsThis[$permissionSlug2]) && $groupPermissionsThis[$permissionSlug2])
                                               checked
                                                @endif
                                        >
                                        <i></i> {{$permissionTitle2}}
                                    </label>
                                </p>
                            @endforeach
                        </section>
                    @else

                        <p><label class="checkbox">
                                <input type="checkbox" value="1" name="permissions[{{$permissionSlug}}]"
                                       @if (isset($groupPermissionsThis[$permissionSlug]) && $groupPermissionsThis[$permissionSlug])
                                       checked
                                        @endif
                                >
                                <i></i> {{$permissionTitle}}
                            </label>
                        </p>

                    @endif
                @endforeach
            </section>
        @else
            <section>
                <p><label class="checkbox">
                        <input type="checkbox" value="1" name="permissions[{{$permissionAlias}}]"
                               @if (isset($groupPermissionsThis[$permissionAlias]) && $groupPermissionsThis[$permissionAlias])
                               checked
                                @endif
                        >
                        <i></i> {{$permission}}
                    </label>
                </p>
            </section>
        @endif

    @endforeach
@endif